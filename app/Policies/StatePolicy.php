<?php

namespace App\Policies;

use App\User;
use App\State;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the State.
     *
     * @param  \App\User  $user
     * @param  \App\State  $state
     * @return mixed
     */
    public function view(User $user, State $state)
    {
        return true;
    }

    /**
     * Determine whether the user can create States.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->manage($user);
    }

    /**
     * Determine whether the user can update the State.
     *
     * @param  \App\User  $user
     * @param  \App\State  $state
     * @return mixed
     */
    public function update(User $user, State $state)
    {
        return $this->manage($user, $state);
    }

    /**
     * Determine whether the user can delete the State.
     *
     * @param  \App\User  $user
     * @param  \App\State  $state
     * @return mixed
     */
    public function delete(User $user, State $state)
    {
        return $this->manage($user, $state);
    }

    /**
     * Determine whether the user can audit the State.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function audit(User $user)
    {
        return $user->permissions()->where('permission', 'audit')->count() == 1;
    }

    /**
     * Determine whether the user can manage States.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function manage(User $user)
    {
        return $user->permissions()->where('permission', 'manage-states')->count() == 1;
    }
}
