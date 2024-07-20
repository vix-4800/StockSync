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
 * @property int $id
 * @property int $team_id
 * @property string $name
 * @property \App\Enums\Marketplace $marketplace
 * @property string $api_token
 * @property string|null $api_user_id
 * @property \Illuminate\Support\Carbon|null $api_token_expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereApiTokenExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereApiUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereMarketplace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereUpdatedAt($value)
 */
	class MarketplaceAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $website
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MarketplaceAccount> $marketplaceAccounts
 * @property-read int|null $marketplace_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MarketplaceAccount> $marketplaceOzonAccounts
 * @property-read int|null $marketplace_ozon_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MarketplaceAccount> $marketplaceWildberriesAccounts
 * @property-read int|null $marketplace_wildberries_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MarketplaceAccount> $marketplaceYandexAccounts
 * @property-read int|null $marketplace_yandex_accounts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereWebsite($value)
 */
	class Team extends \Eloquent {}
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
 * @property string|null $theme
 * @property string|null $theme_color
 * @property array|null $custom_fields
 * @property string|null $avatar_url
 * @property bool $is_blocked
 * @property int|null $team_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\Team|null $team
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
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereThemeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

