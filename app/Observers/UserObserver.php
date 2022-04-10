<?php

namespace App\Observers;

use App\Models\Account;
use App\Models\DataCenter;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $account = new Account();
        $dataCenter = DataCenter::first();
        $account->name = $user->first_name.' Account';
        $account->data_center_id = $dataCenter->id;
        $account->email = $user->email;
        $account->save();
        $account->users()->sync([$user->id => ['role' => 'owner']]);
    }
}
