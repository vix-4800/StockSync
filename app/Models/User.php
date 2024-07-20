<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, HasRoles, Notifiable;

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
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if the user can access the filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole(UserRole::ADMIN) || isset($this->team);
    }

    /**
     * Get the team that owns the user.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
