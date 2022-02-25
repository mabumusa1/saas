<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $authUser = Auth::user();
            if (Auth::user()->accountUser()->first()->role == 'admin') {
                activity('Admin login')
                    ->performedOn($authUser)
                    ->causedBy($authUser)
                    ->log($authUser->getFullNameAttribute().' Login in Admin dashboard');

                return redirect()->route('dashboard.index', Auth::user()->accountUser()->first()->account_id);
            } else {
                activity('Clint login')
                    ->performedOn($authUser)
                    ->causedBy($authUser)
                    ->log($authUser->getFullNameAttribute().' Login in Clint dashboard');

                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
}
