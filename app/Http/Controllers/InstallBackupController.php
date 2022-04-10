<?php

namespace App\Http\Controllers;

use App\Events\CreateBackupEvent;
use App\Events\RestoreBackupEvent;
use App\Http\Requests\StoreInstallBackupRequest;
use App\Models\Account;
use App\Models\Install;
use App\Models\InstallBackup;
use App\Models\Site;

class InstallBackupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Account $account, Site $site, Install $install)
    {
        $backups = $install->backups;

        return view('installs.backups.index', ['account' => $account, 'install' => $install, 'site' => $site, 'backups' => $backups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInstallBackupRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Account $account, Site $site, Install $install, StoreInstallBackupRequest $request)
    {
        $backup = $install->backups()->create([
            's3_url' => '',
            'description' => $request->input('description'),
        ]);

        CreateBackupEvent::dispatch($backup);

        return redirect()->route('installs.backup-points.index', ['account' => $account, 'site' => $site, 'install' => $install]);
    }

    public function restore(Account $account, Site $site, Install $install, InstallBackup $backup)
    {
        RestoreBackupEvent::dispatch($backup);

        return redirect()->route('installs.backup-points.index', ['account' => $account, 'site' => $site, 'install' => $install]);
    }
}
