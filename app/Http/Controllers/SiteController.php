<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiteStoreRequest;
use App\Http\Requests\SiteUpdateRequest;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sites = Site::all();

        return view('site.index', compact('sites'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('site.create');
    }

    /**
     * @param \App\Http\Requests\SiteStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteStoreRequest $request)
    {
        $site = Site::create($request->validated());

        $request->session()->flash('site.id', $site->id);

        return redirect()->route('site.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Site $site)
    {
        return view('site.show', compact('site'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Site $site)
    {
        return view('site.edit', compact('site'));
    }

    /**
     * @param \App\Http\Requests\SiteUpdateRequest $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function update(SiteUpdateRequest $request, Site $site)
    {
        $site->update($request->validated());

        $request->session()->flash('site.id', $site->id);

        return redirect()->route('site.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Site $site)
    {
        $site->delete();

        return redirect()->route('site.index');
    }
}
