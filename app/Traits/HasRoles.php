<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\UserRole;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasRoles
{
    /**
     * Get all of the user's roles.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Assign the given role to the user.
     */
    public function assignRole(UserRole $role): void
    {
        $roleModel = Role::where('name', $role->value)->firstOrFail();
        $this->roles()->attach($roleModel->id);
    }

    /**
     * Determine if the user has the given role.
     */
    public function hasRole(UserRole $role): bool
    {
        return $this->roles()->where('name', $role->value)->exists();
    }

    /**
     * Determine if the user has any of the given roles.
     */
    public function hasAnyRole(array $roles): bool
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Remove the given role from the user.
     */
    public function removeRole(UserRole $role): void
    {
        $roleModel = Role::where('name', $role->value)->firstOrFail();
        $this->roles()->detach($roleModel->id);
    }
}
