<?php

namespace App\Http\Controllers;

use App\Events\ActivityLoggerEvent;
use App\Events\UserCreatedEvent;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Account;
use App\Models\DataCenter;
use App\Models\Invite;
use App\Models\User;
use App\Notifications\InviteNotification;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Notification;
use Session;
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
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Account $account)
    {
        return view('user.index', ['users' => $account->users]);
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
        $token = Str::random(20);
        $account->invites()->create([...$request->validated(), 'token' => $token]);
        $url = URL::temporarySignedRoute(
            'invites.index',
            now()->addMinutes(300),
            ['invite' => $token]
        );
        Notification::route('mail', $request->input('email'))->notify(new InviteNotification($url));

        /* DB::transaction(function () use ($input, $account, $password) {
            return tap(User::create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'password' => Hash::make($password),
            ]), function (User $user) use ($input, $account, $password) {
                $ownAccount = new Account();
                $dataCenter = DataCenter::first();
                $ownAccount->name = $user->first_name.' Account';
                $ownAccount->data_center_id = $dataCenter->id;
                $ownAccount->email = $user->email;
                $ownAccount->save();
                $ownAccount->users()->sync([$user->id => ['role' => 'owner']]);
                $account->users()->syncWithoutDetaching([$user->id => ['role' => $input['role']]]);
                UserCreatedEvent::dispatch($user, $password);
            });
        }); */

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
        /*
         * We only remove the user from the account
         * Do not remove the user
         */

        $account->users()->detach($user->id);

        return redirect()->route('users.index', $account)->with('status', __('User successfully deleted!'));
    }
}
