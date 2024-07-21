<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use Auth;
use Illuminate\Contracts\Support\Htmlable;
use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults as BaseHealthCheckResults;

class Health extends BaseHealthCheckResults
{
    // protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';

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
