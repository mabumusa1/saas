<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Models\Account;
use App\Models\Group;
use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function formValidation()
    {
        // Setup the validator
//        $validatedData = $request->validated();
        echo json_encode(
            [
                'valid' => true,
            ]
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Account $account
     * @return \Illuminate\View\View
     */
    public function index(Account $account, Request $request)
    {
        $order = $request->order ?: 'DESC';
        $sites = $account->sites();
        if ($request->filled('q')) {
            $sites->where('name', 'like', '%'.$request->q.'%')->orWhereHas('installs', function ($query) use ($request) {
                $query->where('name', 'like', '%'.$request->q.'%');
            });
        }
        $sites->orderBy('name', $order);

        return view('sites.index', ['sites' => $sites->get(), 'order' => $order]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Models\Account $account
     * @return \Illuminate\View\View
     */
    public function create(Account $account)
    {
        return view('sites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Http\Requests\StoreSiteRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account, StoreSiteRequest $request)
    {
        return redirect(route('sites.index', $account->id))->with('status', 'Site is under creation, we will send you an update once it is done!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Account $account
     * @param  \App\Models\Site  $site
     * @return \Illuminate\View\View
     */
    public function edit(Account $account, Site $site)
    {
        $groups = $account->groups;

        return view('sites.edit', ['site' => $site, 'account' => $account, 'groups' => $groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Http\Requests\UpdateSiteRequest  $request
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Account $account, UpdateSiteRequest $request, Site $site)
    {
        return redirect(route('sites.index'))->with('status', 'Site has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, Site $site)
    {
        return redirect(route('sites.index'))->with('status', 'Site has been deleted');
    }
}
