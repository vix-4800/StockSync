<?php

declare(strict_types=1);

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Admin extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable;

    /**
     * The guard that should be used for authentication.
     */
    protected string $guard = 'admin';

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
        'avatar_url',
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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if the user can access the filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Get the avatar URL for the user.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url
            ? Storage::url("$this->avatar_url")
            : $this->getFilamentDefaultAvatarUrl();
    }

    /**
     * Get the default avatar URL for the user.
     */
    public function getFilamentDefaultAvatarUrl(): ?string
    {
        return 'https://ui-avatars.com/api/?name='.$this->name.'&rounded=true&background=000&color=fff';
    }

    /**
     * Get the conversations for the user.
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class)->with('messages');
    }
}
