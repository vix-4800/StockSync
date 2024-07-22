<?php

namespace App\Filament\Account\Pages;

use Filament\Pages\Page;

class DeepLinks extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static string $view = 'filament.account.pages.deep-links';

    public static function getNavigationGroup(): ?string
    {
        return __('General Tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('Deep Links');
    }

    public static function canAccess(): bool
    {
        return true;
    }
}
