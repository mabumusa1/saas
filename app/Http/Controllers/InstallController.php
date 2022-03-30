<?php

namespace App\Http\Controllers;

use App\Events\CreateInstallEvent;
use App\Http\Requests\StoreInstallRequest;
use App\Models\Account;
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
     *
     * @param Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Account $account, Site $site, Request $request)
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
     * @return \Illuminate\Contracts\View\View
     */
    public function store(Account $account, Site $site, StoreInstallRequest $request)
    {
        $validated = $request->safe()->all();

        if ($request->has('isValidation')) {
            return response()->json(['valid' => true]);
        }
        dd($request->validated());
        $firstInstall = $site->installs()->first();

        $newInstall = $firstInstall->replicate();
        $newInstall->update($request->validated());
        $newInstall->save();

        CreateInstallEvent::dispatch($newInstall);

        return redirect()->route('installs.show', ['account' => $account, 'site' => $site, 'install' => $newInstall])->with('success', __('New installation is created'));
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
        return view('installs.show', ['account' => $account, 'site' => $site, 'install' => $install]);
    }
}
