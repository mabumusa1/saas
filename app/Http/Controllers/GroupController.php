<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Auth;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $groups = Group::all();

        return view('groups.index', ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        return redirect()->route('groups.index', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\View\View
     */
    public function show(Group $group)
    {
        return view('groups.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\View\View
     */
    public function edit(Group $group)
    {
        return view('groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Group $group)
    {
        $ungrouped = [];
        $grouped = [];

        if ($request->ungrouped_sites != null) {
            for ($i = 1; $i <= 10; $i++) {
                if (array_key_exists('ungrouped_sites_'.$i, array_flip($request->ungrouped_sites))) {
                    $ungrouped['ungrouped_sites_'.$i] = true;
                } else {
                    $ungrouped['ungrouped_sites_'.$i] = false;
                }
            }
        }

        if ($request->grouped_sites != null) {
            for ($i = 1; $i <= 3; $i++) {
                if (array_key_exists('grouped_sites_'.$i, array_flip($request->grouped_sites))) {
                    $grouped['grouped_sites_'.$i] = true;
                } else {
                    $grouped['grouped_sites_'.$i] = false;
                }
            }
        }

        $group->update([
            'name' => $request->name,
            'notes' => $request->notes,
            'ungrouped_sites' => $ungrouped,
            'grouped_sites' => $grouped,
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Group  $group
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Group $group)
    {
        $group->delete();
        //redirect should be updated to groups once we have that page this is temporary
        return redirect()->route('sites.index');
    }
}
