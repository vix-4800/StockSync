<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\InvitationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeInvitation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'token',
        'expires_at',
        'status',
        'team_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'expires_at' => 'datetime',
        'status' => InvitationStatus::class,
    ];

    /**
     * Get the team that owns the invitation.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Invalidate the invitation.
     */
    public function invalidate(): bool
    {
        if ($this->status == InvitationStatus::PENDING) {
            $this->status = InvitationStatus::INVALIDATED;

            return $this->save();
        }

        return false;
    }

    /**
     * Scope a query to only include pending invitations.
     */
    public function scopePending($query)
    {
        return $query->where('status', InvitationStatus::PENDING);
    }

    /**
     * Scope a query to only include accepted invitations.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', InvitationStatus::ACCEPTED);
    }

    /**
     * Scope a query to only include declined invitations.
     */
    public function scopeDeclined($query)
    {
        return $query->where('status', InvitationStatus::DECLINED);
    }
}
