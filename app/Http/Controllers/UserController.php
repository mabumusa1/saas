<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
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

        UserCreated::dispatch($user, $password);

        Session::flash('status', __('User successfully created!'));

        return redirect()->route('users.index', $account);
    }

    /**
     * @param Account $account
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
        $account->users()->updateExistingPivot($user->id, ['role' => $data['role']]);
        Session::flash('status', 'User successfully updated!');

        return redirect()->route('users.index', $account);
    }

    /**
     * @param Account $account
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, User $user)
    {
        $accountUser = AccountUser::where('account_id', $account->id)->where('role', 'owner')->get();

        if ($user->accountUser()->first()->role == 'owner' && count($accountUser) == 1) {
            Session::flash('status', 'Sorry  you  can not delete this user!');

            return redirect()->route('users.index', $account);
        }

        AccountUser::where('user_id', $user->id)->delete();
        $user = User::find($user->id);
        $user->delete();

        Session::flash('status', 'User successfully deleted!');

        $authUser = Auth::user();
        activity('User deleted')
            ->performedOn($user)
            ->causedBy($authUser)
            ->withProperties(['account_id' => $account->id])
            ->log('User deleted by '.$authUser->getFullNameAttribute());

        return redirect()->route('users.index', $account);
    }
}
