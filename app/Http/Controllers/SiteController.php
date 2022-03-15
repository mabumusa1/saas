<?php

namespace App\Http\Controllers;

use App\Events\ActivityLoggerEvent;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Models\Account;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;

class SiteController extends Controller
{
    /**
     * SiteController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Site::class, 'site');
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
        $sites = $sites->get();

        if ($sites->count() === 0) {
            return view('sites.empty');
        }

        return view('sites.index', compact('sites', 'order'));
    }

    public function show(Account $account, Site $site)
    {
        return view('sites.show', compact('site'));
    }

    /**
     * @param Account $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Account $account)
    {
        $installs = $account->installs()->get();
        $subscriptions = $account->subscriptions()->active()->available()->withCount('sites')->get();
        $totalActiveSubscriptions = $account->subscriptions()->active()->sum('quantity');

        return view('sites.create', compact('installs', 'subscriptions', 'totalActiveSubscriptions'));
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
        if($request->has('isValidation')){
            response()->json(['valid' => true]);
        }
        $subscription = $account->subscriptions()->active()->available()->first();

        $account->sites()->create([
            'name' => $request->sitename,
            'subscription_id' => $subscription->id,
        ]);

        return redirect(route('sites.index', $account->id))->with('status', __('Site is under creation, we will send you an update once it is done!'));
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

        return view('sites.edit', compact('site', 'account', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Http\Requests\UpdateSiteRequest  $request
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Account $account, Site $site, UpdateSiteRequest $request)
    {
        $site->update([
            'name' => $request->input('name'),
        ]);

        $site->groups()->sync($request->input('groups'));

        return to_route('sites.index', compact('account'))->with('status', __('Site successfully updated!'));
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
        $site->groups()->detach();
        $site->delete();

        return redirect(route('sites.index', $account->id))->with('status', __('Site successfully deleted!'));
    }
}
