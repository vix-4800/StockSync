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
 * @property string $name
 * @property string $email
 * @property mixed $password
 * @property string|null $theme
 * @property string|null $theme_color
 * @property string|null $avatar_url
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Conversation> $conversations
 * @property-read int|null $conversations_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\AdminFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin query()
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereThemeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Admin whereUpdatedAt($value)
 */
	class Admin extends \Eloquent implements \Filament\Models\Contracts\FilamentUser, \Filament\Models\Contracts\HasAvatar {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $admin_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Admin|null $admin
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Message> $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\ConversationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Conversation whereUserId($value)
 */
	class Conversation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property \App\Enums\Marketplace $marketplace
 * @property string $generated_url
 * @property bool $is_archived
 * @property string $qr_code
 * @property array|null $options
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink archived()
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink notArchived()
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink whereGeneratedUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink whereIsArchived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink whereMarketplace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink whereOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink whereQrCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeepLink whereUserId($value)
 */
	class DeepLink extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $email
 * @property int $team_id
 * @property string $token
 * @property \App\Enums\InvitationStatus $status
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation accepted()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation declined()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation pending()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeInvitation whereUpdatedAt($value)
 */
	class EmployeeInvitation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $file_name
 * @property int $marketplace_account_id
 * @property array|null $supply_numbers
 * @property string|null $supply_dates
 * @property int $sticker_count
 * @property string $created_at
 * @property-read \App\Models\MarketplaceAccount|null $account
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedPdf newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedPdf newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedPdf query()
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedPdf whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedPdf whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedPdf whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedPdf whereMarketplaceAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedPdf whereStickerCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedPdf whereSupplyDates($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GeneratedPdf whereSupplyNumbers($value)
 */
	class GeneratedPdf extends \Eloquent {}
}

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
 * @property \Illuminate\Support\Carbon|null $api_token_created_at
 * @property \Illuminate\Support\Carbon|null $api_token_expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GeneratedPdf> $files
 * @property-read int|null $files_count
 * @property-read \App\Models\Team|null $team
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereApiToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MarketplaceAccount whereApiTokenCreatedAt($value)
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
 * @property int $conversation_id
 * @property string $text
 * @property bool $is_sent_by_user
 * @property bool $is_read
 * @property string $created_at
 * @property-read \App\Models\Conversation|null $conversation
 * @method static \Database\Factories\MessageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Message query()
 * @method static \Illuminate\Database\Eloquent\Builder|Message read()
 * @method static \Illuminate\Database\Eloquent\Builder|Message sentByAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|Message sentByUser()
 * @method static \Illuminate\Database\Eloquent\Builder|Message unread()
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereConversationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereIsRead($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereIsSentByUser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Message whereText($value)
 */
	class Message extends \Eloquent {}
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
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeInvitation> $invitations
 * @property-read int|null $invitations_count
 * @property-read \App\Models\User|null $manager
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
 * @method static \Database\Factories\TeamFactory factory($count = null, $state = [])
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
 * @property int $user_id
 * @property string $token
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TelegramToken whereUserId($value)
 */
	class TelegramToken extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $theme
 * @property string|null $theme_color
 * @property array|null $custom_fields
 * @property string|null $avatar_url
 * @property \App\Enums\UserRole $role
 * @property bool $is_blocked
 * @property int|null $team_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Conversation> $conversations
 * @property-read int|null $conversations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\DeepLink> $deepLinks
 * @property-read int|null $deep_links_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Team|null $team
 * @property-read \App\Models\TelegramToken|null $telegramToken
 * @method static \Illuminate\Database\Eloquent\Builder|User active()
 * @method static \Illuminate\Database\Eloquent\Builder|User blocked()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User unverified()
 * @method static \Illuminate\Database\Eloquent\Builder|User verified()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCustomFields($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsBlocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereThemeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser, \Filament\Models\Contracts\HasAvatar, \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

