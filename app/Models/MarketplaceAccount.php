<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Marketplace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MarketplaceAccount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'team_id',
        'name',
        'marketplace',
        'api_token',
        'api_user_id',
        'api_token_created_at',
        'api_token_expires_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'api_token_created_at' => 'date',
        'api_token_expires_at' => 'date',
        'marketplace' => Marketplace::class,
    ];

    /**
     * Get the team that owns the MarketplaceAccount
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the files that belong to the MarketplaceAccount
     */
    public function files(): HasMany
    {
        return $this->hasMany(GeneratedPdf::class);
    }
}
