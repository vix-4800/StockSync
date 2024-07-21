<?php

declare(strict_types=1);

namespace App\Filament\Account\Resources\EmployeeResource\Pages;

use App\Enums\InvitationStatus;
use App\Filament\Account\Resources\EmployeeResource;
use App\Models\EmployeeInvitation;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListEmployees extends ListRecords
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('invite')
                ->action(function (array $data) {
                    $token = Str::random(32);
                    $team = auth()->user()->team;

                    $invitation = EmployeeInvitation::where('email', $data['email'])
                        ->where('team_id', $team->id)
                        ->where('status', InvitationStatus::PENDING);

                    if ($invitation->exists()) {
                        Notification::make()
                            ->title(__('Invitation Already Sent'))
                            ->warning()
                            ->send();
                    } else {
                        EmployeeInvitation::create([
                            'email' => $data['email'],
                            'token' => $token,
                            'team_id' => $team->id,
                            'expires_at' => now()->addDay(),
                        ]);

                        Notification::make()
                            ->title(__('Invitation Sent'))
                            ->success()
                            ->send();
                    }
                })
                ->form([
                    TextInput::make('email')
                        ->required()
                        ->unique()
                        ->placeholder('Email Address')
                        ->label(__('Email Address'))
                        ->prefixIcon('heroicon-o-envelope')
                        ->email(),
                ])
                ->modalSubmitActionLabel(__('Invite'))
                ->label(__('Invite Employee'))
                ->openUrlInNewTab(),
        ];
    }
}
