<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Install;

class InstallController extends Controller
{
    /**
     * Show Install dashboard.
     *
     * @param Account $account
     *
     * @param Install $install
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Account $account, Install $install)
    {
        return view('installs.show', ['account' => $account, 'install' => $install]);
    }
}
