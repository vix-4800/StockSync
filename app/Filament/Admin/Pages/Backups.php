<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use Auth;
use Illuminate\Contracts\Support\Htmlable;
use ShuvroRoy\FilamentSpatieLaravelBackup\Pages\Backups as BaseBackups;

class Backups extends BaseBackups
{
    protected static ?int $navigationSort = 3;

    public static function canAccess(): bool
    {
        return Auth::user()->isAdmin();
    }

    public function getHeading(): string|Htmlable
    {
        return 'Application Backups';
    }

    public static function getNavigationGroup(): ?string
    {
        return __('System Management');
    }
}
