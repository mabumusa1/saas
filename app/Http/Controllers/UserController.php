<?php

namespace App\Http\Controllers;

use App\Events\UserCreatedEvent;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Session;

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
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Account $account)
    {
        $canEditOwner = $account->users()->where('account_user.role', 'owner')->count() > 1;

        return view('user.index', ['users' => $account->users, 'canEditOwner' => $canEditOwner]);
    }

    /**
     * @param Account $account
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Account $account)
    {
        return view('user.create', compact('account'));
    }

    /**
     * @param Account $account
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account, StoreUserRequest $request)
    {
        $data = $request->all();
        $password = Str::random(16);
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($password),
        ]);

        $user->accounts()->attach($account, ['role' => $data['role']]);

        UserCreatedEvent::dispatch($user, $password);

        return redirect()->route('users.index', $account)->with('status', __('User successfully created!'));
    }

    /**
     * @param Account $account
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Account $account, User $user)
    {
        return view('user.edit', compact('user'));
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
        $user->update($data);
        $account->users()->updateExistingPivot($user->id, ['role' => $data['role']]);

        return redirect()->route('users.index', $account)->with('status', __('User successfully updated!'));
    }

    /**
     * @param Account $account
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, User $user)
    {
        if ($account->users()->wherePivot('role', 'owner')->count() == 1) {
            return redirect()->route('users.index', $account)->with('status', 'Sorry  you  can not delete this user!');
        }

        /*
         * We only remove the user from the account
         * Do not remove the user
         */

        $account->users()->detach($user->id);

        activity('User deleted')
            ->performedOn($user)
            ->causedBy(request()->user())
            ->withProperties(['account_id' => $account->id])
            ->log('User deleted by '.request()->user()->fullName);

        return redirect()->route('users.index', $account)->with('status', __('User successfully deleted!'));
    }
}
