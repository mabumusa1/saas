<?php

namespace App\Http\Controllers;

use App\Events\CreateInstallEvent;
use App\Events\InstallCopyEvent;
use App\Events\InstallDeleteEvent;
use App\Http\Requests\CopyInstallRequest;
use App\Http\Requests\StoreInstallRequest;
use App\Models\Account;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InstallController extends Controller
{
    /**
     * Create a new install.
     *
     * @param Account $account
     *
     * @param Site $site
     * @return \Illuminate\View\View | \Illuminate\Http\RedirectResponse
     */
    public function create(Account $account, Site $site)
    {
        $envs = $site->installs->pluck('type')->toArray();
        $allowed = ['prd', 'stg', 'dev'];
        $envs = array_diff($allowed, $envs);
        /// The user is not allowed to create more envs
        if ([] === $envs) {
            return redirect()->route('installs.show', ['account' => $account, 'site' => $site, 'install' => $site->installs()->first()])->with('error', __('You can not create more installs for this site'));
        }

        $selectedEnv = '';
        if (in_array(request()->query('env'), $envs)) {
            $selectedEnv = request()->query('env');
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
        $validated = $request->safe()->all();

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

        CreateInstallEvent::dispatch($install);

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
        InstallCopyEvent::dispatch($install);

        //TODO: Add code to notify the email in the request

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
        return view('installs.live-check.index', compact('account', 'site', 'install'));
    }

    public function webRules(Account $account, Site $site, Install $install)
    {
        return view('installs.web-rules.index', compact('account', 'site', 'install'));
    }

    public function cron(Account $account, Site $site, Install $install)
    {
        return view('installs.cron.index', compact('account', 'site', 'install'));
    }
}
