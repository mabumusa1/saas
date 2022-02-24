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
     * GroupController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Group::class, 'group');
    }

    /**
     * @param Account $account
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
     * @param Account $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Account $account)
    {
        return view('groups.create', compact('account'));
    }

    /**
     * @param Account $account
     * @param StoreGroupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account, StoreGroupRequest $request)
    {
        $group = $account->groups()->create($request->validated());

        session()->flash('success', 'Group created successfully.');

        return to_route('groups.edit', compact('account', 'group'));
    }

    /**
     * @param Account $account
     * @param Group $group
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Account $account, Group $group)
    {
        $sites = $account->sites;
        $groups = $account->groups;

        return view('groups.edit', compact('account', 'group', 'sites', 'groups'));
    }

    /**
     * @param Account $account
     * @param Group $group
     * @param UpdateGroupRequest $request
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
        session()->flash('success', 'Group updated successfully.');

        return to_route('groups.edit', compact('account', 'group'));
    }

    /**
     * @param Account $account
     * @param Group $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, Group $group)
    {
        $group->sites()->detach();
        $group->delete();
        session()->flash('success', 'Group deleted successfully.');

        return to_route('groups.index', compact('account'));
    }
}
