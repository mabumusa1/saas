<?php

namespace App\Http\Controllers;

use App\Events\UserCreatedEvent;
use App\Http\Requests\AcceptInviteRequest;
use App\Models\Account;
use App\Models\DataCenter;
use App\Models\Invite;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Illuminate\Http\Request;

class InviteController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth')->except('index');
    }

    public function index(Invite $invite)
    {
        if (Auth::check()) {
            return view('auth.invitation', compact('invite'));
        }

        if (User::where('email', $invite->email)->exists()) {
            session()->put('url.intended', route('invites.index', ['invite' => $invite->token]));

            return redirect()->route('login')->with('error', 'Please Login First');
        } else {
            return redirect()->route('register');
        }
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
