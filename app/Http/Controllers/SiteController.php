<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiteRequest;
use App\Http\Requests\UpdateSiteRequest;
use App\Models\Account;
use App\Models\Group;
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
     * @param Account $account
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
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
     * @param Account $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create(Account $account)
    {
        $installs = Install::all();

        return view('sites.create', compact('installs'));
    }

    /**
     * @param Account $account
     * @param StoreSiteRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Account $account, StoreSiteRequest $request)
    {
        return redirect(route('sites.index', $account->id))->with('status', 'Site is under creation, we will send you an update once it is done!');
    }

    /**
     * @param Account $account
     * @param Site $site
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Account $account, Site $site)
    {
        $groups = $account->groups;

        return view('sites.edit', ['site' => $site, 'account' => $account, 'groups' => $groups]);
    }

    /**
     * @param UpdateSiteRequest $request
     * @param Account $account
     * @param Site $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateSiteRequest $request, Account $account, Site $site)
    {
        $site->update([
            'name' => $request->input('name'),
        ]);
        $site->groups()->sync($request->input('groups'));

        return to_route('sites.index', compact('account'));
    }

    /**
     * @param Account $account
     * @param Site $site
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Account $account, Site $site)
    {
        $site->groups()->detach();
        $site->installs->each(function ($install) {
            $install->contact()->delete();
        });
        $site->installs()->delete();
        $site->delete();

        return redirect(route('sites.index', $account->id))->with('status', 'Site has been deleted');
    }
}
