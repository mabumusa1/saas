<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGroupRequest;
use App\Http\Requests\UpdateGroupRequest;
use App\Models\Account;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param \App\Models\Account $account
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Account $account, Request $request)
    {
        if (! Gate::allows('isPb') && ! Gate::allows('isPnb')) {
            dd('You don not have access on this page');
        }

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
        if (! Gate::allows('isPb') && ! Gate::allows('isPnb')) {
            dd('You don not have access on this page');
        }

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
        if (! Gate::allows('isPb') && ! Gate::allows('isPnb')) {
            dd('You don not have access on this page');
        }

        $account->Groups()->create($request->validated());

        return to_route('groups.index', compact('account'));
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
        if (! Gate::allows('isPb') && ! Gate::allows('isPnb')) {
            dd('You don not have access on this page');
        }

        $sites = $account->sites;
        $groups = Group::all();

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
        if (! Gate::allows('isPb') && ! Gate::allows('isPnb')) {
            dd('You don not have access on this page');
        }

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
        if (! Gate::allows('isPb') && ! Gate::allows('isPnb')) {
            dd('You don not have access on this page');
        }

        $group->sites()->detach();
        $group->delete();

        return to_route('groups.index', compact('account'));
    }
}
