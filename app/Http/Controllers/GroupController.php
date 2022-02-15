<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $groups = Group::all();

        return view('group.index', compact('groups'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('group.create');
    }

    /**
     * @param \App\Http\Requests\GroupStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupStoreRequest $request)
    {
        $group = Group::create($request->validated());

        $request->session()->flash('group.id', $group->id);

        return redirect()->route('group.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Group $group)
    {
        return view('group.show', compact('group'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Group $group)
    {
        return view('group.edit', compact('group'));
    }

    /**
     * @param \App\Http\Requests\GroupUpdateRequest $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function update(GroupUpdateRequest $request, Group $group)
    {
        $group->update($request->validated());

        $request->session()->flash('group.id', $group->id);

        return redirect()->route('group.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Group $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Group $group)
    {
        $group->delete();

        return redirect()->route('group.index');
    }
}
