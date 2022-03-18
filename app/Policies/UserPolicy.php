<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        $allowedRoles = ['admin', 'owner'];
        if (is_null($this->account)) {
            $this->account = $user->accounts()->first();
        }

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
        $allowedRoles = ['admin', 'owner'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        $allowedRoles = ['admin', 'owner'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        $allowedRoles = ['admin', 'owner'];

        return $user->belongToRoles($this->account, $allowedRoles) && $this->account->users()->wherePivot('role', 'owner')->count() > 1;
    }

    /**
     * Determine whether the user can change the role of the owenr.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function changeOwner(User $user)
    {
        $allowedRoles = ['admin', 'owner'];

        return $user->belongToRoles($this->account, $allowedRoles) && $this->account->users()->wherePivot('role', 'owner')->count() > 1;
    }
}
