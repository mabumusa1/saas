<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Session;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index(Account $account, Request $request)
    {
        if ($request->user()->accounts()->first()->pivot->role === 'admin') {
            if ($request->filled('q')) {
                $activities = Activity::where('properties->account_id', $request->q)->get();
            } else {
                $activities = Activity::all();
            }
        } else {
            $activities = Activity::where('properties->account_id', $account->id)->get();
        }

        return view('log.index', compact('activities', 'account'));
    }
}
