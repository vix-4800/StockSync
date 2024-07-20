<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Marketplace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
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
        return $this->hasMany(MarketplaceAccount::class)->where('marketplace', Marketplace::OZON);
    }

    /**
     * Get the Yandex accounts that belong to the team.
     */
    public function marketplaceYandexAccounts(): HasMany
    {
        return $this->hasMany(MarketplaceAccount::class)->where('marketplace', Marketplace::YANDEXMARKET);
    }

    /**
     * Get the Wildberries accounts that belong to the team.
     */
    public function marketplaceWildberriesAccounts(): HasMany
    {
        return $this->hasMany(MarketplaceAccount::class)->where('marketplace', Marketplace::WILDBERRIES);
    }
}
