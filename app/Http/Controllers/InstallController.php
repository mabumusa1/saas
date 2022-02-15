<?php

namespace App\Http\Controllers;

use App\Http\Requests\InstallStoreRequest;
use App\Http\Requests\InstallUpdateRequest;
use App\Models\Install;
use Illuminate\Http\Request;

class InstallController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $installs = Install::all();

        return view('install.index', compact('installs'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('install.create');
    }

    /**
     * @param \App\Http\Requests\InstallStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstallStoreRequest $request)
    {
        $install = Install::create($request->validated());

        $request->session()->flash('install.id', $install->id);

        return redirect()->route('install.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Install $install
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Install $install)
    {
        return view('install.show', compact('install'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Install $install
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Install $install)
    {
        return view('install.edit', compact('install'));
    }

    /**
     * @param \App\Http\Requests\InstallUpdateRequest $request
     * @param \App\Models\Install $install
     * @return \Illuminate\Http\Response
     */
    public function update(InstallUpdateRequest $request, Install $install)
    {
        $install->update($request->validated());

        $request->session()->flash('install.id', $install->id);

        return redirect()->route('install.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Install $install
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Install $install)
    {
        $install->delete();

        return redirect()->route('install.index');
    }
}
