<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\BackupsCheck;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\QueueCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Facades\Health;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;

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
                // ->flags([
                //     'en' => asset('img/flags/usa.png'),
                //     'ru' => asset('img/flags/ru.png'),
                // ])
                ->locales(['en', 'ru'])
                ->circular();
        });

        Schema::defaultStringLength(125);

        Health::checks([
            DatabaseCheck::new(),
            CacheCheck::new(),
            BackupsCheck::new()->locatedAt(storage_path('app/' . config('app.name') . '/*.zip')),
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            QueueCheck::new()->onQueue('default'),
            ScheduleCheck::new(),
            SecurityAdvisoriesCheck::new(),
        ]);
    }
}
