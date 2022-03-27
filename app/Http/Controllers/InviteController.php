<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptInviteRequest;
use App\Models\Invite;
use App\Models\User;
use Auth;

class InviteController extends Controller
{
    public function __construct()
    {
    }

    public function index(Invite $invite)
    {
        if (Auth::check()) {
            return view('auth.invitation', ['invite' => $invite]);
        }

        if (User::where('email', $invite->email)->exists()) {
            session()->put('url.intended', route('invites.index', ['invite' => $invite->token]));

            return redirect()->route('login')->with('error', 'Please Login First');
        }

        return redirect()->route('register');
    }

    public function accept(AcceptInviteRequest $request)
    {
        $invite = Invite::where('token', $request->token)->firstOrFail();
        $account = $invite->account;
        $user = User::where('email', $invite->email)->first();
        $account->users()->syncWithoutDetaching([$user->id => ['role' => $invite->role]]);
        $invite->delete();

        return redirect()->route('home', ['account' => $account]);
    }
}
