<?php

namespace App\Http\Controllers;

use App\Casts\RoleCast;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Account;
use App\Models\AccountUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use Session;

class UserController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

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
        return view('user.create', compact('account'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account, StoreUserRequest $request)
    {
        $data = $request->all();

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
        ]);

        AccountUser::create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => $data['role'],
        ]);

        Session::flash('status', 'User successfully created!');

        return redirect()->route('users.index', $account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Account $account
     * @param  \App\Models\User $user
     * @return \Illuminate\View\View
     */
    public function edit(Account $account, User $user)
    {
        return view('user.edit', compact('account', 'user'));
    }

    /**
     * @param Account $account
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Account $account, UpdateUserRequest $request, User $user)
    {
        $data = $request->all();
        $accountUser = AccountUser::where('user_id', $user->id)->first();
        $accountUser->update([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => $data['role'],
        ]);

        $user->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
        ]);

        Session::flash('status', 'User successfully updated!');

        return redirect()->route('users.index', $account);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, User $user)
    {
        $accountUser = AccountUser::where('account_id', $account->id)->where('role', 'owner')->get();

        if (count($accountUser) == 1) {
            Session::flash('status', 'Sorry  you  can not delete this user!');

            return redirect()->route('users.index', $account);
        }

        AccountUser::where('user_id', $user->id)->delete();
        $user = User::find($user->id);
        $user->delete();

        Session::flash('status', 'User successfully deleted!');

        return redirect()->route('users.index', $account);
    }
}
