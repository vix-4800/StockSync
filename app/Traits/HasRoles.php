<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\UserRole;
use App\Models\Role;

trait HasRoles
{
    /**
     * Assign the given role to the user.
     */
    public function assignRole(UserRole $role): void
    {
        $this->role = $role->value;
        $this->save();
    }

    /**
     * Remove the given role from the user.
     */
    public function removeRole(): void
    {
        $this->role = null;
        $this->save();
    }

    /**
     * Determine if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    /**
     * Determine if the user is a team manager.
     */
    public function isManager(): bool
    {
        return $this->role === UserRole::MANAGER;
    }
}
