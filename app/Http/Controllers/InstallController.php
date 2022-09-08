<?php

namespace App\Http\Controllers;

use App\Http\Requests\CopyInstallRequest;
use App\Http\Requests\StoreInstallRequest;
use App\Models\Account;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Site;
use App\Notifications\InstallCopyNotification;
use Notification;

class InstallController extends Controller
{
    /**
     * Create a new install.
     *
     * @param Account $account
     *
     * @param Site $site
     *
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public function create(Account $account, Site $site)
    {
        $envs = $site->installs->pluck('type')->toArray();
        $requestedEnv = request()->query('env');

        // The user is not allowed to create duplicate environemnt
        if (in_array($requestedEnv, $envs)) {
            return redirect()->route('installs.show', ['account' => $account, 'site' => $site, 'install' => $site->installs()->first()])->with('error', __('You have already created '.$requestedEnv.' site'));
        }

        $allowed = ['prd', 'dev'];
        $envs = array_diff($allowed, $envs);
        /// The user is not allowed to create more envs
        if ($envs === []) {
            return redirect()->route('installs.show', ['account' => $account, 'site' => $site, 'install' => $site->installs()->first()])->with('error', __('You can not create more installs for this site'));
        }

        $selectedEnv = '';
        if (in_array($requestedEnv, $envs)) {
            $selectedEnv = $requestedEnv;
        } else {
            $selectedEnv = reset($envs);
        }

        return view('installs.create', ['account' => $account, 'site' => $site, 'envs' => $envs, 'selectedEnv' => $selectedEnv]);
    }

    /**
     * Store a new install.
     *
     * @param Account $account
     *
     * @param Site $site
     *
     * @param StoreInstallRequest $request
     *
     * @return \Illuminate\Http\JsonResponse | \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account, Site $site, StoreInstallRequest $request)
    {
        if ($request->has('isValidation')) {
            return response()->json(['valid' => true]);
        }
        $data = $request->validated();
        $data['site_id'] = $site->id;
        $install = Install::create($data);
        Domain::create([
            'install_id' => $install->id,
            /* @phpstan-ignore-next-line */
            'name' => $install->cname,
            'primary' => true,
            'verified' => true,
            'verified_at' => now(),
        ]);

        return redirect()->route('installs.show', ['account' => $account, 'site' => $site, 'install' => $install])->with('success', __('New installation is created'));
    }

    /**
     * Copy an installation.
     *
     * @param Account $account
     *
     * @param Site $site
     *
     * @param CopyInstallRequest $request
     *
     * @return \Illuminate\Http\JsonResponse | \Illuminate\Http\RedirectResponse
     */
    public function copy(Account $account, Site $site, Install $install, CopyInstallRequest $request)
    {
        $install->copy();

        Notification::route('mail', $request->input('email'))->notify(new InstallCopyNotification($install));

        return redirect()->route('installs.show', ['account' => $account, 'site' => $site, 'install' => $install])->with('success', __('Copy Request Sent'));
    }

    /**
     * Show Install dashboard.
     *
     * @param Account $account
     *
     * @param Install $install
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Account $account, Site $site, Install $install)
    {
        $installs = $site->installs()->where('id', '!=', $install->id)->get();

        return view('installs.show', ['account' => $account, 'site' => $site, 'install' => $install, 'installs' => $installs]);
    }

    public function lock(Account $account, Site $site, Install $install)
    {
        $install->lock();

        return redirect()->route('installs.show', ['account' => $account, 'site' => $site, 'install' => $install])->with('success', __('Installation is locked'));
    }

    /*
    Methods at here are not in final place or shape.
    They may get moved or deleted in future.
    they are here until we get better place to put them in.
    */

    public function cdn(Account $account, Site $site, Install $install)
    {
        return view('installs.cdn.index', compact('account', 'site', 'install'));
    }

    public function redirectRules(Account $account, Site $site, Install $install)
    {
        return view('installs.redirect-rules.index', compact('account', 'site', 'install'));
    }

    public function backupPoints(Account $account, Site $site, Install $install)
    {
        return view('installs.backup-points.index', compact('account', 'site', 'install'));
    }

    public function accessLogs(Account $account, Site $site, Install $install)
    {
        return view('installs.logs.access', compact('account', 'site', 'install'));
    }

    public function errorLogs(Account $account, Site $site, Install $install)
    {
        return view('installs.logs.error', compact('account', 'site', 'install'));
    }

    public function utilities(Account $account, Site $site, Install $install)
    {
        return view('installs.utilities.index', compact('account', 'site', 'install'));
    }

    public function caching(Account $account, Site $site, Install $install)
    {
        return view('installs.caching.index', compact('account', 'site', 'install'));
    }

    public function migration(Account $account, Site $site, Install $install)
    {
        return view('installs.migration.index', compact('account', 'site', 'install'));
    }

    public function liveCheck(Account $account, Site $site, Install $install)
    {
        return view('installs.live-checklist.index', compact('account', 'site', 'install'));
    }

    public function webRules(Account $account, Site $site, Install $install)
    {
        return view('installs.web-rules.index', compact('account', 'site', 'install'));
    }

    public function cron(Account $account, Site $site, Install $install)
    {
        return view('installs.cron.index', compact('account', 'site', 'install'));
    }

    /**
     * Delete an install.
     *
     * @param Account $account
     * @param Site $site
     * @param Install $install
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, Site $site, Install $install)
    {
        if ($site->installs->count() === 1) {
            return redirect()->back()->with('error', __('Any site must has at least one install, if you want to delete this install, please delete the whole site'));
        }

        $install->delete();

        return redirect()->route('sites.index', [$account])->with('success', __('Install Deleted Successfully'));
    }
}
