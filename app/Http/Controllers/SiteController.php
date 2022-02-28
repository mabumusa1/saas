<?php

namespace App\Http\Controllers;

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

    public function formValidation()
    {
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
        $sites = $sites->get();

        return view('sites.index', compact('sites', 'order'));
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
        Session::flash('status', 'Site is under creation, we will send you an update once it is done!');

        return redirect(route('sites.index', $account->id));
    }

    /**
     * @param Account $account
     * @param Site $site
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Account $account, Site $site)
    {
        $groups = $account->groups;

        return view('sites.edit', compact('site', 'account', 'groups'));
    }

    /**
     * @param Account $account
     * @param Site $site
     * @param UpdateSiteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Account $account, Site $site, UpdateSiteRequest $request)
    {
        $site->update([
            'name' => $request->input('name'),
        ]);
        $site->groups()->sync($request->input('groups'));

        Session::flash('status', 'Site successfully updated!');

        return to_route('sites.index', compact('account'));
    }

    /**
     * @param Account $account
     * @param Site $site
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Account $account, Site $site)
    {
        $authUser = Auth::user();
        $site->groups()->detach();
        $site->installs->each(function ($install) use ($authUser, $account) {
            activity('Install deleted')
                ->performedOn($install)
                ->causedBy($authUser)
                ->withProperties(['account_id' => $account->id])
                ->log('User created by '.$authUser->getFullNameAttribute());
            $install->contact()->delete();
        });

        activity('Site deleted')
            ->performedOn($site)
            ->causedBy($authUser)
            ->withProperties(['account_id' => $account->id])
            ->log('Site deleted by '.$authUser->getFullNameAttribute());

        $site->installs()->delete();
        $site->delete();

        Session::flash('status', 'Site successfully deleted!');

        return redirect(route('sites.index', $account->id));
    }
}
