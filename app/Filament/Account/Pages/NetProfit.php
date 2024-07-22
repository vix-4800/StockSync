<?php

namespace App\Filament\Account\Pages;

use Filament\Pages\Page;

class NetProfit extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static string $view = 'filament.account.pages.net-profit';

    public static function getNavigationGroup(): ?string
    {
        return __('General Tools');
    }

    public static function getNavigationLabel(): string
    {
        return __('Net Profit Calculator');
    }

    public static function canAccess(): bool
    {
        return true;
    }
}
