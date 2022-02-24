<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * @param Account $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Account $account)
    {
        $accounts = Account::where('id', '!=', $account->id)->get();

        return view('admin.dashboard.index', compact('accounts'));
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

    /**
     * @param Account $account
     * @param User $user
     */
    public function destroy(Account $account, User $user)
    {
    }
}
