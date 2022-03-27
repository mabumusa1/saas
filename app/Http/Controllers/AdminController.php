<?php

namespace App\Http\Controllers;

use App\Models\Account;

class AdminController extends Controller
{
    /**
     * @param Account $account
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Account $account)
    {
        $accounts = Account::where('id', '!=', $account->id)->get();

        return view('admin.index', ['accounts' => $accounts]);
    }
}
