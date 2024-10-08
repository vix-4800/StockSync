<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use App\Models\Admin;
use BezhanSalleh\FilamentLanguageSwitch\LanguageSwitch;
use Encodia\Health\Checks\EnvVars;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
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

        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Disable lazy loading for production
        Model::preventLazyLoading(! app()->isProduction());

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
            BackupsCheck::new()->locatedAt(storage_path('app/'.config('app.name').'/*.zip')),
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            QueueCheck::new()->onQueue('default'),
            ScheduleCheck::new(),
            SecurityAdvisoriesCheck::new(),
            EnvVars::new()
                ->requireVars([
                    'DB_DATABASE',
                    'DB_USERNAME',
                    'DB_PASSWORD',

                    'MAIL_MAILER',
                    'MAIL_HOST',
                    'MAIL_PORT',
                    'MAIL_USERNAME',
                    // 'MAIL_PASSWORD',
                    'MAIL_ENCRYPTION',
                    'MAIL_FROM_ADDRESS',
                    'MAIL_FROM_NAME',
                    'MAIL_FROM_ADDRESS',
                    'MAIL_BACKUP_HOST',

                    'DEEP_LINKS_URL',

                    'YANDEXGPT_FODER_ID',
                    'YANDEXGPT_FINETUNED_MODEL',
                    'YANDEXGPT_IAM_TOKEN',

                    'TELEGRAM_BOT_TOKEN',
                    'TELEGRAM_WEBHOOK_URL',
                ]),
        ]);

        Gate::define('viewPulse', function (?Authenticatable $user) {
            return $user instanceof Admin;
        });
    }
}
