<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Install;
use Illuminate\Http\Request;

class InstallController extends Controller
{
    public function show(Account $account, Install $install)
    {
        return view('installs.show', compact('account', 'install'));
    }
}
