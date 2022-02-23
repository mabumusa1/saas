<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Account;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Group::class, 'group');
    }

    /**
     * Display a listing of the resource.
     * @param \App\Models\Account $account
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Account $account, Request $request)
    {
        $groups = $account->groups();
        if ($request->filled('q')) {
            $groups->where('name', 'like', '%'.$request->q.'%')->orWhereHas('sites', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->q.'%');
            });
        }

        return view('groups.index', ['groups' => $groups->get(), 'account' => $account]);
    }

    /**
     * Show the form for creating a new resource.
     * @param \App\Models\Account $account
     * @return \Illuminate\View\View
     */
    public function create(Account $account)
    {
        return view('groups.create', compact('account'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Http\Requests\StoreGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account, StoreGroupRequest $request)
    {
        $group = $account->groups()->create($request->validated());

        return to_route('groups.edit', compact('account', 'group'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Account $account
     * @param  \App\Models\Group $group
     * @return \Illuminate\View\View
     */
    public function edit(Account $account, Group $group)
    {
        $sites = $account->sites;
        $groups = $account->groups;

        return view('groups.edit', compact('account', 'group', 'sites', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Models\Group $group
     * @param  \App\Http\Requests\UpdateGroupRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Account $account, Group $group, UpdateGroupRequest $request)
    {
        $group->update([
            'name' => $request->input('name'),
            'notes' => $request->input('notes'),
        ]);
        if ($request->input('sites') && count($request->input('sites')) > 0) {
            $group->sites()->sync($request->input('sites'));
        } else {
            $group->sites()->detach();
        }

        return to_route('groups.index', compact('account'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Models\Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, Group $group)
    {
        $group->sites()->detach();
        $group->delete();

        return to_route('groups.index', compact('account'));
    }
}
