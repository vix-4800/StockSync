<?php

declare(strict_types=1);

namespace App\Filament\Account\Resources;

use App\Enums\InvitationStatus;
use App\Filament\Account\Resources\EmployeeInvitationResource\Pages\ListEmployeeInvitations;
use App\Models\EmployeeInvitation;
use Auth;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class EmployeeInvitationResource extends Resource
{
    protected static ?string $model = EmployeeInvitation::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?int $navigationSort = 10;

    public static function canAccess(): bool
    {
        return Auth::user()->isManager() && Auth::user()->hasTeam();
    }

    public static function getEloquentQuery(): Builder
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        return $user->team
            ->invitations()
            ->getQuery();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Team Management');
    }

    public static function getNavigationLabel(): string
    {
        return __('Invitations');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Invitations');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('expires_at')
                    ->label(__('Expires At'))
                    ->sortable()
                    ->dateTime(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->sortable()
                    ->icon(fn (EmployeeInvitation $record): string => match ($record->status) {
                        InvitationStatus::PENDING => 'heroicon-o-clock',
                        InvitationStatus::ACCEPTED => 'heroicon-o-check-circle',
                        InvitationStatus::DECLINED => 'heroicon-o-x-circle',
                        InvitationStatus::INVALIDATED => 'heroicon-o-x-circle',
                    })
                    ->color(fn (EmployeeInvitation $record): string => match ($record->status) {
                        InvitationStatus::PENDING => 'warning',
                        InvitationStatus::ACCEPTED => 'success',
                        InvitationStatus::DECLINED => 'danger',
                        InvitationStatus::INVALIDATED => 'danger',
                    })
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->native(false)
                    ->options([
                        InvitationStatus::PENDING->value => __('Pending'),
                        InvitationStatus::ACCEPTED->value => __('Accepted'),
                        InvitationStatus::DECLINED->value => __('Declined'),
                        InvitationStatus::INVALIDATED->value => __('Invalidated'),
                    ])
                    ->label(__('Status')),
            ], layout: FiltersLayout::AboveContent)
            ->actions([
                ActionGroup::make([
                    Action::make('invalidate')
                        ->label(__('Invalidate'))
                        ->color('danger')
                        ->icon('heroicon-o-x-circle')
                        ->visible(fn (EmployeeInvitation $record): bool => $record->status === InvitationStatus::PENDING)
                        ->action(fn (EmployeeInvitation $record) => $record->invalidate()),
                ])
                    ->tooltip(__('Actions')),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('invalidate_selected')
                        ->label(__('Invalidate Selected'))
                        ->action(function (Collection $records): void {
                            $records->each(fn (EmployeeInvitation $employeeInvitation) => $employeeInvitation->invalidate());
                        }),
                ]),
            ])
            ->emptyStateHeading(__('No Invitations Found'));
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
            'index' => ListEmployeeInvitations::route('/'),
        ];
    }
}
