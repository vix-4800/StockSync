<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Marketplace;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeepLink extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'marketplace',
        'generated_url',
        'is_archived',
        'qr_code',
        'options',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_archived' => 'boolean',
        'marketplace' => Marketplace::class,
        'options' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * Get the user that owns the deep link.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Archive the deep link.
     */
    public function archive(): void
    {
        $this->is_archived = true;
        $this->save();
    }

    /**
     * Unarchive the deep link.
     */
    public function unarchive(): void
    {
        $this->is_archived = false;
        $this->save();
    }

    /**
     * Check if the deep link is archived.
     */
    public function isArchived(): bool
    {
        return $this->is_archived;
    }

    /**
     * Scope a query to only include archived deep links.
     */
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    /**
     * Scope a query to only include not archived deep links.
     */
    public function scopeNotArchived($query)
    {
        return $query->where('is_archived', false);
    }
}
