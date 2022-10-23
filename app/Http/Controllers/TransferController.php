<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptTransferRequest;
use App\Http\Requests\CheckTransferRequest;
use App\Http\Requests\StartTransferRequest;
use App\Models\Account;
use App\Models\Install;
use App\Models\Site;
use App\Models\Transfer;
use App\Notifications\TransferRequestNotification;
use Notification;
use Str;

class TransferController extends Controller
{
    /**
     * Start the transfer process.
     *
     * @param  \App\Models\Account  $account
     *
     * @param  \App\Models\Site  $site
     *
     * @param  \App\Models\Install  $install
     *
     * @param  \App\Http\Requests\StartTransferRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start(Account $account, Site $site, Install $install, StartTransferRequest $request)
    {
        $this->authorize('start', Transfer::class);

        $code = Str::random(16);
        $data = $request->validated();
        $data['code'] = $code;
        $install->transfer()->create($data);

        Notification::route('mail', $data['email'])
            ->notify(new TransferRequestNotification($code));

        return redirect()->back()->with('success', __('Transfer Request Sent'));
    }

    /**
     * Check transfer key.
     *
     * @param  \App\Models\Account  $account
     *
     * @param  \App\Http\Requests\CheckTransferRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function check(Account $account, CheckTransferRequest $request)
    {
        $this->authorize('accept', Transfer::class);
        $transfer = Transfer::where('code', $request->input('code'))->first();

        return redirect()->route('transfer.show', [$account, $transfer])->with('code', $transfer->code);
    }

    /**
     * Check transfer key.
     *
     * @param  \App\Models\Account  $account
     *
     * @param  \App\Models\Transfer  $transfer
     *
     * @return \Illuminate\View\View
     */
    public function show(Account $account, Transfer $transfer)
    {
        $this->authorize('show', $transfer);

        //TODO: Fix transfer
        return view('transfers.show', ['account' => $account, 'transfer' => $transfer]);
    }

    /**
     * Accept Transfer.
     *
     * @param  \App\Models\Account  $account
     *
     * @param  \App\Models\Transfer  $transfer
     *
     * @param  \App\Http\Requests\AcceptTransferRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Account $account, Transfer $transfer, AcceptTransferRequest $request)
    {
        $data = $request->validated();

        if ($request->input('transfer_way') === 'existing') {
            $site = $account->sites()->findOrFail($data['site_id']);
        } else {
            $site = $account->sites()->create(['name' => $data['site_name']]);
        }

        $install = Install::find($transfer->install_id);
        $install->update([
            'site_id' => $site->id,
            'locked' => false,
        ]);

        $transfer->delete();

        return redirect()->route('installs.show', ['account' => $account, 'site' => $install->site, 'install' => $install])->with('success', __('Transfer Accepted'));
    }
}
