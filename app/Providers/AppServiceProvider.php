<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
            $switch
                ->locales(['en', 'ru'])
                ->circular();
        });

        Schema::defaultStringLength(125);
    }
}
