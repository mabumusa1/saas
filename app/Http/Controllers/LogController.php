<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Activity;
use Illuminate\Support\Facades\Gate;

class LogController extends Controller
{
    /**
     * Shows Logging Dashboard.
     *
     * @param Account $account
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Account $account)
    {
        if (Gate::allows('isAdmin')) {
            $activities = Activity::all();
        } else {
            $activities = Activity::onAccount($account->id)->get();
        }

        return view('log.index', ['activities' => $activities, 'account' => $account]);
    }
}
