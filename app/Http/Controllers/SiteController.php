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
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $sites = Site::all();
        $groups = Group::all();

        return view('sites.index', ['sites' => $sites, 'groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        return redirect()->route('site.show', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\View\View
     */
    public function show(Site $site)
    {
        return view('sites.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\View\View
     */
    public function edit(Site $site)
//    public function edit(Group $group) // temporary
    {
        return view('groups.edit', compact('site'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Site $site)
    {
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Site $site)
    {
        return redirect()->back();
    }
}
