<?php

declare(strict_types=1);

namespace App\Filament\Account\Pages;

use Filament\Pages\Page;

class Support extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    protected static string $view = 'filament.account.pages.support';

    protected static ?int $navigationSort = 12;

    public ?array $data = [];

    public static function getNavigationGroup(): ?string
    {
        return __('Personal');
    }

    public static function getNavigationLabel(): string
    {
        return __('Need Help?');
    }
}
