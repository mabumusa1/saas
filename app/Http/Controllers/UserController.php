<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Account $account
     * @return \Illuminate\View\View
     */
    public function index(Account $account)
    {
        return view('user.index', ['users' => $account->users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Account $account
     * @return \Illuminate\View\View
     */
    public function create(Account $account)
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account, Request $request)
    {
        return redirect(route('users.index', $account->id))->with('status', 'User has been created');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Account $account
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(Account $account, $id)
    {
        return view('user.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Account $account, Request $request, $id)
    {
        return redirect(route('users.index', $account->id))->with('status', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Account $account
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, $id)
    {
        return redirect(route('users.index', $account->id))->with('status', 'User has been deleted');
    }
}
