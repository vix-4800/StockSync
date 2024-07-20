<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Marketplace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MarketplaceAccount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'name',
        'marketplace',
        'api_token',
        'api_user_id',
        'api_token_expires_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'api_token_expires_at' => 'datetime',
        'marketplace' => Marketplace::class,
    ];

    /**
     * Get the team that owns the MarketplaceAccount
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
