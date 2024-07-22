<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Authenticatable $user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Authenticatable $user, User $model): bool
    {
        return $user instanceof Admin || $user->is($model->team->manager);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Authenticatable $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Authenticatable $user, User $model): bool
    {
        return $user instanceof Admin || $user->is($model->team->manager);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Authenticatable $user, User $model): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Authenticatable $user, User $model): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Authenticatable $user, User $model): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(Authenticatable $user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(Authenticatable $user): bool
    {
        return $user instanceof Admin;
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(Authenticatable $user): bool
    {
        return $user instanceof Admin;
    }
}
