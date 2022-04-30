<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class AccountPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user, Account $account)
    {
        if (Gate::allows('isAdmin', $account)) {
            return true;
        }

        return $account->users()->find($user->id) ? true : false;
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function changeBilling(User $user, Account $account)
    {
        $allowedRoles = ['admin', 'owner', 'fb', 'fnb'];

        return $user->belongToRoles($account, $allowedRoles);
    }
}
