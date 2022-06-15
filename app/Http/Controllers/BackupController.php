<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBackupRequest;
use App\Models\Account;
use App\Models\Backup;
use App\Models\Install;
use App\Models\Site;

class BackupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Account $account, Site $site, Install $install)
    {
        $backups = $install->backups()->orderBy('created_at', 'DESC')->get();

        return view('installs.backups.index', ['account' => $account, 'install' => $install, 'site' => $site, 'backups' => $backups]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreBackupRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Account $account, Site $site, Install $install, StoreBackupRequest $request)
    {
        $install->backups()->create([
            'description' => $request->input('description'),
        ]);

        return redirect()->route('backups.index', ['account' => $account, 'site' => $site, 'install' => $install]);
    }

    public function restore(Account $account, Site $site, Install $install, Backup $backup)
    {
        $backup->restore();

        return redirect()->route('backups.index', ['account' => $account, 'site' => $site, 'install' => $install]);
    }
}
