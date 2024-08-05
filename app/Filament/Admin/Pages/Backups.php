<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use Illuminate\Contracts\Support\Htmlable;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as BaseBackups;

class Backups extends BaseBackups
{
    protected static ?int $navigationSort = 2;

    public function getHeading(): string|Htmlable
    {
        return __('Application Backups');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('System Management');
    }
}
