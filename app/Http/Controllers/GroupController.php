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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Account $account)
    {
        return view('groups.create', compact('account'));
    }

    public function store(Account $account, StoreGroupRequest $request)
    {
        $group = $account->groups()->create($request->validated());

        return to_route('groups.edit', compact('account', 'group'));
    }

    public function edit(Account $account, Group $group)
    {
        $sites = $account->sites;
        $groups = $account->groups;

        return view('groups.edit', compact('account', 'group', 'sites', 'groups'));
    }

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

    public function destroy(Account $account, Group $group)
    {
        $group->sites()->detach();
        $group->delete();

        return to_route('groups.index', compact('account'));
    }
}
