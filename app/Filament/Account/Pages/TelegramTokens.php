<?php

namespace App\Filament\Account\Pages;

use Filament\Pages\Page;

class TelegramTokens extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static string $view = 'filament.account.pages.telegram-tokens';

    public static function getNavigationGroup(): ?string
    {
        return __('General Tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('Telegram Tokens');
    }
}
