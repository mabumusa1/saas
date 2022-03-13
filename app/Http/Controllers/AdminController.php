<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Account;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * @param Account $account
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Account $account)
    {
        $accounts = Account::where('id', '!=', $account->id)->get();

        return view('admin.index', compact('accounts'));
    }
}
