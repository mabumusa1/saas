<?php

namespace App\Http\Controllers;

use App\Http\Requests\DomainStoreRequest;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('domain.create');
    }

    /**
     * @param \App\Http\Requests\DomainStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(DomainStoreRequest $request)
    {
        $request->session()->flash('domain.id', $domain->id);

        return redirect()->route('site.show', [$site.id]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Domain $domain
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Domain $domain)
    {
        $domain->delete();

        return redirect()->route('site.show', [$site.id]);
    }
}
