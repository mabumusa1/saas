<?php

namespace App\Policies;

use App\Models\Group;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
{
    use HandlesAuthorization;

    private $account;

    public function __construct()
    {
        $this->account = request()->route('account');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        $allowedRoles = ['owner', 'fb', 'fnb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $allowedRoles = ['owner', 'fb', 'fnb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Group $group)
    {
        $allowedRoles = ['owner', 'fb', 'fnb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Group $group)
    {
        $allowedRoles = ['owner', 'fb', 'fnb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }
}
