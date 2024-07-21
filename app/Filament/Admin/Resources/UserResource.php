<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources;

use App\Enums\UserRole;
use App\Filament\Admin\Resources\UserResource\Pages\EditUser;
use App\Filament\Admin\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Archilex\ToggleIconColumn\Columns\ToggleIconColumn;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getNavigationGroup(): ?string
    {
        return __('Administration');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('User Info'))
                    ->collapsible()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->minLength(4)
                            ->label(__('Name'))
                            ->placeholder(__('Name'))
                            ->maxLength(125),
                        DateTimePicker::make('email_verified_at')
                            ->placeholder(__('Not Verified'))
                            ->native(false)
                            ->label(__('Email Verified At')),
                        Fieldset::make(__('Contact Info'))
                            ->schema([
                                TextInput::make('email')
                                    ->email()
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->label(__('Email'))
                                    ->placeholder(__('Email'))
                                    ->minLength(4)
                                    ->maxLength(125),
                                PhoneInput::make('phone')
                                    ->label(__('Phone'))
                                    ->unique(ignoreRecord: true)
                                    ->defaultCountry('RU')
                                    ->placeholder(__('Phone')),
                            ])
                            ->columns(2),
                    ])
                    ->columns(2),
                Section::make(__('Team Info'))
                    ->collapsible()
                    ->schema([
                        Select::make('team_id')
                            ->label(__('Team'))
                            ->native(false)
                            ->searchable()
                            ->placeholder(__('Not Defined'))
                            ->preload()
                            ->relationship('team', 'name'),
                        Select::make('role')
                            ->native(false)
                            ->options([
                                UserRole::MANAGER->value => __('Manager'),
                                UserRole::ADMIN->value => __('Admin'),
                                UserRole::USER->value => __('User'),
                            ])
                            ->label(__('Role'))
                            ->placeholder(__('None')),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('avatar_url')
                    ->label(__('Avatar'))
                    ->toggleable(),
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->sortable()
                    ->label(__('Email'))
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->label(__('Verified'))
                    ->placeholder(__('Not Verified'))
                    ->toggleable()
                    ->sortable(),
                PhoneColumn::make('phone')
                    ->label(__('Phone'))
                    ->sortable()
                    ->searchable()
                    ->placeholder(__('Not Defined'))
                    ->toggleable(),
                TextColumn::make('team.name')
                    ->numeric()
                    ->label(__('Team'))
                    ->placeholder(__('Not Defined'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role')
                    ->badge()
                    ->toggleable()
                    ->label(__('Role')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->label(__('Created At'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleIconColumn::make('is_blocked')
                    ->label(__('Blocked'))
                    ->onIcon('heroicon-s-lock-closed')
                    // ->alignCenter()
                    ->onColor('gray')
                    ->sortable()
                    ->offIcon('heroicon-s-lock-open')
                    ->hoverColor(fn (User $record): string => $record->isBlocked() ? 'danger' : 'success'),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->label(__('Last Modified'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('team')
                    ->label(__('Team'))
                    ->native(false)
                    ->searchable()
                    ->preload()
                    ->selectablePlaceholder(false)
                    ->relationship('team', 'name'),
                TrashedFilter::make()
                    ->native(false)
                    ->label(__('Deleted')),
                SelectFilter::make('role')
                    ->label(__('Role'))
                    ->options([
                        UserRole::MANAGER->value => __('Manager'),
                        UserRole::USER->value => __('User'),
                        UserRole::ADMIN->value => __('Admin'),
                    ])
                    ->native(false),
                SelectFilter::make('is_blocked')
                    ->label(__('Blocked'))
                    ->native(false)
                    ->placeholder(__('All'))
                    ->options([
                        '1' => __('Yes'),
                        '0' => __('No'),
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                ActionGroup::make([
                    Action::make('verify')
                        ->label(__('Verify'))
                        ->color('success')
                        ->visible(fn (User $record) => ! $record->hasVerifiedEmail())
                        ->icon('heroicon-s-check-circle')
                        ->action(fn (User $record) => $record->markEmailAsVerified()),
                    RestoreAction::make(),
                    EditAction::make(),
                ])
                    ->tooltip(__('Actions')),

            ])
            ->bulkActions([
                BulkActionGroup::make([
                    Action::make('verify_selected')
                        ->label(__('Verify Selected'))
                        ->color('success')
                        ->icon('heroicon-s-check-circle')
                        ->action(fn (Collection $records) => $records->each(fn (User $record) => $record->markEmailAsVerified()))
                        ->requiresConfirmation(),
                    DeleteBulkAction::make(),
                ]),
            ])
            ->toggleColumnsTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label(__('Columns')),
            )
            ->emptyStateHeading(__('No Users'))
            ->defaultGroup('team.name')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('id', '!=', auth()->id()));
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
