<?php

namespace App\Http\Controllers;

use App\Events\CreateInstallEvent;
use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Models\Account;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Http\Request;

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
     *
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

        return view('sites.index', ['sites' => $sites, 'order' => $order]);
    }

    /**
     * @param Account $account
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Account $account)
    {
        $installs = $account->installs()->get();
        $subscriptions = $account->subscriptions()->active()->available()->withCount('sites')->get();
        $totalActiveSubscriptions = $account->subscriptions()->active()->sum('quantity');

        return view('sites.create', ['installs' => $installs, 'subscriptions' => $subscriptions, 'totalActiveSubscriptions' => $totalActiveSubscriptions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Http\Requests\StoreSiteRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function store(Account $account, StoreSiteRequest $request)
    {
        $validated = $request->safe()->all();

        if ($request->has('isValidation')) {
            return response()->json(['valid' => true]);
        }

        $siteData = [];

        if ($request->filled('subscription_id')) {
            $subscription = $account->subscriptions()->active()->available()->where('id', $validated['subscription_id'])->first();
            if (is_null($subscription)) {
                return redirect(route('sites.index', $account->id))->with('status', __('Subscription not found, site was not created'));
            }
            $siteData['subscription_id'] = $subscription->id;
        }

        $siteData['account_id'] = $account->id;
        $siteData['name'] = $validated['sitename'];

        $site = $account->sites()->create($siteData);

        $install = Install::create([
            'site_id' => $site->id,
            'name' => $validated['installname'],
            'type' => $validated['type'],
            'owner' => $validated['owner'] ?? null,
            'locked' => $validated['owner'] === 'transferable',
        ]);

        CreateInstallEvent::dispatch($install, $validated['start'] ?? null);

        return redirect(route('sites.index', $account->id))->with('status', __('Site is under creation, we will send you an update once it is done!'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Account $account
     * @param  \App\Models\Site  $site
     *
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
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Account $account, Site $site, UpdateSiteRequest $request)
    {
        $site->update([
            'name' => $request->input('name'),
        ]);

        $site->groups()->sync($request->input('groups'));

        return to_route('sites.index', ['account' => $account])->with('status', __('Site successfully updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Models\Site  $site
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, Site $site)
    {
        $site->groups()->detach();
        $site->delete();

        return redirect(route('sites.index', $account->id))->with('status', __('Site successfully deleted!'));
    }
}
