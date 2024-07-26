<?php

namespace App\Filament\Account\Pages;

use App\Models\TelegramToken;
use Auth;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Pages\Page;
use Firebase\JWT\JWT;

class TelegramTokens extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static string $view = 'filament.account.pages.telegram-tokens';

    public string $token = '';

    public static function getNavigationGroup(): ?string
    {
        return __('General Tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('Telegram Tokens');
    }

    public static function canAccess(): bool
    {
        return true;
    }

    public function mount(): void
    {
        $this->token = Auth::user()->telegramToken->token ?? '';
    }

    public function tokenInfoList(Infolist $infoList): Infolist
    {
        return $infoList
            ->schema([
                TextEntry::make('token')
                    ->label(__('Your Telegram Token'))
                    ->copyable()
                    ->hint(fn (): string => $this->token ? __('Click to copy') : '')
                    ->copyMessage(__('Your token has been copied to the clipboard.'))
                    ->placeholder(__('Token')),
            ])->state([
                'token' => $this->token,
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate')
                ->label(__('Generate Token'))
                ->visible(fn (): bool => ! $this->token)
                ->action(function () {
                    $key = env('TELEGRAM_BOT_TOKEN');
                    $payload = [
                        'iss' => Auth::id(),
                        'aud' => Auth::id(),
                        'iat' => time(),
                        'nbf' => time(),
                    ];
                    $jwt = JWT::encode($payload, $key, 'HS256');

                    TelegramToken::insert([
                        'user_id' => Auth::id(),
                        'token' => $jwt,
                    ]);

                    redirect(static::getUrl());
                }),
        ];
    }
}
