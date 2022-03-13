<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index(Account $account, Request $request)
    {
        if (Auth::user()->accountUser()->first()->role == 'admin') {
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

    /**
     * @param Account $account
     */
    public function create(Account $account)
    {
    }

    /**
     * @param Account $account
     * @param StoreUserRequest $request
     */
    public function store(Account $account, StoreUserRequest $request)
    {
    }

    /**
     * @param Account $account
     * @param User $user
     */
    public function edit(Account $account, User $user)
    {
    }

    /**
     * @param Account $account
     * @param UpdateUserRequest $request
     * @param User $user
     */
    public function update(Account $account, UpdateUserRequest $request, User $user)
    {
    }

    public function destroy(Account $account, $activity)
    {
        DB::table('activity_log')->where('id', $activity)->delete();
        Session::flash('status', 'Log deleted successfully!');

        return redirect()->route('logs.index', $account);
    }
}
