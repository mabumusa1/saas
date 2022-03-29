<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstallRequest;
use App\Models\Account;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Http\Request;

class InstallController extends Controller
{
    public function create(Account $account, Sites $site, Request $request)
    {
        dd($site);
        $envs = array_unique($install->site->installs->pluck('type')->toArray());
        abort_if(in_array($request->query('env'), $envs), 403);

        return view('installs.create', ['account' => $account, 'install' => $install, 'site' => $install->site, 'envs' => $envs]);
    }

    public function store(StoreInstallRequest $request, Account $account, Install $install)
    {
        $newInstall = $install->replicate();
        $newInstall->update($request->validated());
        $newInstall->save();

        return redirect()->route('sites.index', ['account' => $account]);
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
        $envs = array_unique($install->site->installs->pluck('type')->toArray());

        return view('installs.show', ['account' => $account, 'site' => $site, 'install' => $install, 'envs' => $envs]);
    }
}
