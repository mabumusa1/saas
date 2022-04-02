<?php

namespace App\Policies;

use App\Models\Transfer;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransferPolicy
{
    use HandlesAuthorization;

    private $account;

    public function __construct()
    {
        $this->account = request()->route('account');
    }

    /**
     * Determine whether the user can transfer installs.
     *
     * @param  \App\Models\User  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function start(User $user)
    {
        $allowedRoles = ['admin', 'owner', 'fb', 'fnb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    public function show(User $user, Transfer $transfer)
    {
        $allowedRoles = ['admin', 'owner', 'fb', 'fnb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function accept(User $user)
    {
        $allowedRoles = ['admin', 'owner', 'fb', 'fnb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }
}
