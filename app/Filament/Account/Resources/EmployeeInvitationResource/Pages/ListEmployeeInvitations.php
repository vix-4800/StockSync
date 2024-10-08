<?php

declare(strict_types=1);

namespace App\Filament\Account\Resources\EmployeeInvitationResource\Pages;

use App\Filament\Account\Resources\EmployeeInvitationResource;
use App\Models\EmployeeInvitation;
use Auth;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

class ListEmployeeInvitations extends ListRecords
{
    protected static string $resource = EmployeeInvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('invite')
                ->action(function (array $data) {
                    $token = Str::random(32);

                    /** @var \App\Models\User */
                    $user = Auth::user();

                    $team = $user->team;

                    $invitation = EmployeeInvitation::where('email', $data['email'])
                        ->where('team_id', $team->id)
                        ->pending();

                    if ($invitation->exists()) {
                        Notification::make()
                            ->title(__('Invitation Already Sent'))
                            ->warning()
                            ->send();
                    } else {
                        $team->invitations()->create([
                            'email' => $data['email'],
                            'token' => $token,
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
