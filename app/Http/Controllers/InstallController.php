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

    /**
     * Delete an install.
     *
     * @param Account $account
     * @param Site $site
     * @param Install $install
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function destroy(Account $account, Site $site, Install $install)
    {
        InstallDeleteEvent::dispatch($install);
        $install->delete();

        return redirect()->back()->with('success', __('Install Deleted Successfully'));
    }
}
