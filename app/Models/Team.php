<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Marketplace;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'website',
    ];

    /**
     * Get the users that belong to the team.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the employees that belong to the team.
     */
    public function employees(): HasMany
    {
        return $this->hasMany(User::class)
            ->active()
            ->where('role', UserRole::USER);
    }

    /**
     * Get the manager that owns the team.
     */
    public function manager(): HasOne
    {
        return $this->hasOne(User::class)
            ->active()
            ->where('role', UserRole::MANAGER);
    }

    /**
     * Get the accounts that belong to the team.
     */
    public function marketplaceAccounts(): HasMany
    {
        return $this->hasMany(MarketplaceAccount::class);
    }

    /**
     * Get the Ozon accounts that belong to the team.
     */
    public function marketplaceOzonAccounts(): HasMany
    {
        return $this->hasMany(MarketplaceAccount::class)
            ->where('marketplace', Marketplace::OZON);
    }

    /**
     * Get the Yandex accounts that belong to the team.
     */
    public function marketplaceYandexAccounts(): HasMany
    {
        return $this->hasMany(MarketplaceAccount::class)
            ->where('marketplace', Marketplace::YANDEXMARKET);
    }

    /**
     * Get the Wildberries accounts that belong to the team.
     */
    public function marketplaceWildberriesAccounts(): HasMany
    {
        return $this->hasMany(MarketplaceAccount::class)
            ->where('marketplace', Marketplace::WILDBERRIES);
    }

    /**
     * Get the invitations that belong to the team.
     */
    public function invitations(): HasMany
    {
        return $this->hasMany(EmployeeInvitation::class);
    }
}
