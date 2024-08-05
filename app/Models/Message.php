<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'conversation_id',
        'text',
        'is_read',
        'is_sent_by_user',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'is_read' => 'boolean',
        'is_sent_by_user' => 'boolean',
    ];

    /**
     * Get the conversation that the message belongs to.
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Determine if the message was sent by the user.
     */
    public function isSentByUser(): bool
    {
        return $this->is_sent_by_user;
    }

    /**
     * Scope a query to only include read messages.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope a query to only include unread messages.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include sent by the user messages.
     */
    public function scopeSentByUser($query)
    {
        return $query->where('is_sent_by_user', true);
    }

    /**
     * Scope a query to only include sent by the admin messages.
     */
    public function scopeSentByAdmin($query)
    {
        return $query->where('is_sent_by_user', false);
    }
}
