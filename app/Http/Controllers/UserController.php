<?php

namespace App\Http\Controllers;

use App\Events\UserInvitedEvent;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Str;
use URL;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * @param Account $account
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Account $account)
    {
        return view('user.index', ['users' => $account->users]);
    }

    /**
     * @param Account $account
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Account $account)
    {
        return view('user.create', ['account' => $account]);
    }

    /**
     * @param Account $account
     * @param StoreUserRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account, StoreUserRequest $request)
    {
        $token = Str::random(20);
        $account->invites()->create([...$request->validated(), 'token' => $token]);
        $url = URL::temporarySignedRoute(
            'invites.index',
            now()->addMinutes(300),
            ['invite' => $token]
        );

        UserInvitedEvent::dispatch(['email' => $request->input('email'), 'url' => $url]);

        return redirect()->route('users.index', $account)->with('status', __('User successfully invited!'));
    }

    /**
     * @param Account $account
     * @param User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Account $account, User $user)
    {
        return view('user.edit', ['user' => $user]);
    }

    /**
     * @param Account $account
     * @param UpdateUserRequest $request
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Account $account, UpdateUserRequest $request, User $user)
    {
        $account->users()->updateExistingPivot($user->id, ['role' => $request->input('role')]);

        return redirect()->route('users.index', $account)->with('status', __('User successfully updated!'));
    }

    /**
     * @param Account $account
     * @param User $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, User $user)
    {
        /*
         * We only remove the user from the account
         * Do not remove the user
         */

        $account->users()->detach($user->id);

        return redirect()->route('users.index', $account)->with('status', __('User successfully deleted!'));
    }
}
