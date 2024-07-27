<?php

declare(strict_types=1);

namespace App\Filament\Account\Resources;

use App\Filament\Account\Resources\EmployeeResource\Pages\ListEmployees;
use App\Filament\Account\Resources\EmployeeResource\Pages\ViewEmployee;
use App\Models\User;
use Auth;
use Filament\Infolists\Components\Fieldset as InfolistFieldset;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Ysfkaya\FilamentPhoneInput\Tables\PhoneColumn;

class EmployeeResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 9;

    public static function canAccess(): bool
    {
        return Auth::user()->hasTeam() && Auth::user()->isManager();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Team Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Employees');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Employees');
    }

    public static function getEloquentQuery(): Builder
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        return $user->team
            ->employees()
            ->with('team')
            ->getQuery();
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfolistSection::make(__('User Info'))
                    ->collapsible()
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('Name'))
                            ->placeholder(__('Name')),
                        InfolistFieldset::make(__('Contact Info'))
                            ->schema([
                                TextEntry::make('email')
                                    ->label(__('Email'))
                                    ->placeholder(__('Email')),
                                TextEntry::make('phone')
                                    ->label(__('Phone'))
                                    ->placeholder(__('Phone')),
                            ])
                            ->columns(2),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_url')
                    ->label(__('Avatar'))
                    ->circular()
                    ->defaultImageUrl(fn (User $record): string => $record->getFilamentDefaultAvatarUrl())
                    ->toggleable(),
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->sortable()
                    ->label(__('Email'))
                    ->searchable(),
                PhoneColumn::make('phone')
                    ->label(__('Phone'))
                    ->sortable()
                    ->searchable()
                    ->placeholder(__('Not Defined'))
                    ->toggleable(),
            ])
            ->filters([], layout: FiltersLayout::AboveContent)
            ->actions([
                ActionGroup::make([
                    Action::make('fire')
                        ->label(__('Fire'))
                        ->color('danger')
                        ->icon('heroicon-o-user-minus')
                        ->requiresConfirmation()
                        ->action(fn (User $record) => $record->fire()),
                ])
                    ->tooltip(__('Actions')),

            ])
            ->bulkActions([])
            ->toggleColumnsTriggerAction(
                fn (Action $action) => $action
                    ->button()
                    ->label(__('Columns')),
            )
            ->emptyStateHeading(__('No Employees In Team'));
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployees::route('/'),
            'view' => ViewEmployee::route('/{record}'),
        ];
    }
}
