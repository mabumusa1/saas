<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginAsClient extends Controller
{
    public function loginAsClient(Account $account, Request $request)
    {
        if (! empty($account)) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            if (! empty($account)) {
                $user = $account->users()->first();
                if ($user) {
                    Auth::guard('web')->login($user);

                    return redirect()->route('dashboard');
                } else {
                    return redirect()->route('login');
                }
            }
        } else {
            return back();
        }
    }
}
