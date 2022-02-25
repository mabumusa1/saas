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
    /**
     * @param Account $account
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function loginAsClient(Account $account, Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $user = $account->users()->first();
        if ($user) {
            Auth::guard('web')->login($user);
            activity('Admin login in Client dashboard')
                ->performedOn($user)
                ->causedBy($user)
                ->log('Admin login as '.roles()[$user->accountUser->role]);

            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    }
}
