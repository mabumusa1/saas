<?php

namespace App\Http\Controllers;

use App\Models\Environment;
use Illuminate\Http\Request;

class EnvironmentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('environments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        return redirect()->route('environments.show', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Environment  $environment
     * @return \Illuminate\View\View
     */
    public function show(Environment $environment)
    {
        return view('environments.show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Environment  $environment
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function destroy(Environment $environment)
    {
        return redirect()->route('environments.show', []);
    }
}
