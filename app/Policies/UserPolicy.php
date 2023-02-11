<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $user, User $model)
    {
        return $user->isStaff() || $user->id === $model->id;
    }

    public function ban(User $user, User $model)
    {
        return $user->isAdmin() && (!$model->isAdmin());
    }
}
