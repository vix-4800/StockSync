<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            Actions\Action::make('verify')
                ->action(function () {
                    $this->record->markEmailAsVerified();
                })
                ->color('success')
                ->visible(! $this->record->hasVerifiedEmail())
                ->label(__('Verify')),
        ];
    }
}
