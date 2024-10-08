<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use Illuminate\Contracts\Support\Htmlable;
use ShuvroRoy\FilamentSpatieLaravelHealth\Pages\HealthCheckResults as BaseHealthCheckResults;

class Health extends BaseHealthCheckResults
{
    protected static ?int $navigationSort = 3;

    public function getHeading(): string|Htmlable
    {
        return __('Health Check');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('System Management');
    }
}
