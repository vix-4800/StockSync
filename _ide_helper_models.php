<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property \App\Enums\Marketplace $marketplace
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount query()
 */
	class MarketplaceAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $theme
 * @property string|null $theme_color
 * @property string|null $custom_fields
 * @property string|null $avatar_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MarketplaceAccount> $marketplaceAccounts
 * @property-read int|null $marketplace_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MarketplaceAccount> $marketplaceOzonAccounts
 * @property-read int|null $marketplace_ozon_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MarketplaceAccount> $marketplaceWildberriesAccounts
 * @property-read int|null $marketplace_wildberries_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MarketplaceAccount> $marketplaceYandexAccounts
 * @property-read int|null $marketplace_yandex_accounts_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCustomFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereThemeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

