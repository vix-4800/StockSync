<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Admin\Pages\Backups;
use App\Filament\Admin\Pages\Health;
use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\IsBlockedMiddleware;
use Auth;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Hasnayeen\Themes\ThemesPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Saade\FilamentLaravelLog\FilamentLaravelLogPlugin;
use ShuvroRoy\FilamentSpatieLaravelBackup\FilamentSpatieLaravelBackupPlugin;
use ShuvroRoy\FilamentSpatieLaravelHealth\FilamentSpatieLaravelHealthPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('admin')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->widgets([])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetTheme::class,
                IsBlockedMiddleware::class,
                IsAdminMiddleware::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                ThemesPlugin::make(),
                FilamentEditProfilePlugin::make()
                    ->setNavigationGroup(__('Personal'))
                    ->setTitle(__('Edit Profile'))
                    ->setNavigationLabel(__('Edit Profile'))
                    ->setIcon('heroicon-o-user'),
                FilamentSpatieLaravelBackupPlugin::make()
                    ->usingQueue('default')
                    ->usingPage(Backups::class),
                FilamentSpatieLaravelHealthPlugin::make()
                    ->usingPage(Health::class),
                FilamentLaravelLogPlugin::make()
                    ->navigationGroup(__('System Management'))
                    ->navigationLabel(__('Logs'))
                    ->navigationIcon('heroicon-o-bug-ant')
                    ->navigationSort(4)
                    ->authorize(fn (): bool => Auth::user()->isAdmin())
                    ->slug('logs'),
            ])
            ->favicon(asset('images/sellersphere/favicon.ico'))
            ->unsavedChangesAlerts()
            ->databaseNotifications();
    }
}
