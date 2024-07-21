<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'theme',
        'theme_color',
        'custom_fields',
        'avatar_url',
        'team_id',
        'is_blocked',
        'phone',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'custom_fields' => 'array',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_blocked' => 'boolean',
        'role' => UserRole::class,
    ];

    /**
     * Check if the user can access the filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() || $this->hasTeam();
    }

    /**
     * Get the team that owns the user.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Check if the user has a team.
     */
    public function hasTeam(): bool
    {
        return $this->team_id !== null;
    }

    /**
     * Fire the user.
     */
    public function fire(): void
    {
        $this->team_id = null;
        $this->save();
    }

    /**
     * Check if the user is blocked.
     */
    public function isBlocked(): bool
    {
        return $this->is_blocked;
    }

    /**
     * Change the user's blocked status.
     */
    public function changeBlockedStatus(): void
    {
        $this->is_blocked = ! $this->is_blocked;
        $this->save();
    }
}
