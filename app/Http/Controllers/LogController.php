<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Session;

class LogController extends Controller
{
    public function index(Account $account, Request $request)
    {
        if (Gate::allows('isAdmin')) {
            $activities = Activity::all();
        } else {
            $activities = Activity::onAccount($account->id)->get();
        }

        return view('log.index', compact('activities', 'account'));
    }
}
