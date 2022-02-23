<?php

namespace App\Policies;

use App\Models\Account;
use App\Models\Site;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
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
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Site $site)
    {
        $allowedRoles = ['owner', 'fb', 'fnb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Site $site)
    {
        $allowedRoles = ['owner'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    /**
     * Determine whether the user can copy the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function copy(User $user, Site $site)
    {
        $allowedRoles = ['owner', 'fb', 'fnb', 'pb', 'pnb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    /**
     * Determine whether the user can transfer the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function transfer(User $user, Site $site)
    {
        $allowedRoles = ['owner', 'fb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }

    /**
     * Determine whether the user can accept transfer the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function acceptTransfer(User $user, Site $site)
    {
        $allowedRoles = ['owner', 'fb', 'fnb'];

        return $user->belongToRoles($this->account, $allowedRoles);
    }
}
