<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index(Account $account, Site $site, Install $install)
    {
        return view('installs.domains.index', ['account' => $account, 'site' => $site, 'install' => $install]);
    }
}
