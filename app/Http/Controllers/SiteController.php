<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Site;
use Auth;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
<<<<<<< HEAD
        $sites = Site::where('team_id', Auth::user()->currentTeam->id)->get();

        // this only for testing should be removed if the creation and the index are dynamic
        $group = Group::first();

        return view('sites.index', compact('sites', 'group'));
=======
        $sites = Site::all();
        $groups = Group::all();

        return view('sites.index', ['sites' => $sites, 'groups' => $groups]);
    }

    /**
     * Send Sites as JSON.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request)
    {
        return response()->json($sites);
>>>>>>> vuejs work
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function show(Site $site)
    {
        return view('sites.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    // public function edit(Site $site)
    public function edit(Group $group) // temporary
    {
        return view('groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Site $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $site)
    {
        //
    }
}
