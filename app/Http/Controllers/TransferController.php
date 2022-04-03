<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptTransferRequest;
use App\Http\Requests\CheckTransferRequest;
use App\Http\Requests\StartTransferRequest;
use App\Models\Account;
use App\Models\Install;
use App\Models\Transfer;
use App\Notifications\TransferRequestNotification;
use Illuminate\Notifications\AnonymousNotifiable;
use Notification;
use Str;

class TransferController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Account  $account
     *
     * @param  \App\Http\Requests\StartTransferRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function start(Account $account, StartTransferRequest $request)
    {
        $this->authorize('start', Transfer::class);

        $code = Str::random(16);
        $data = $request->validated();
        $data['code'] = $code;
        $account->transfers()->create($data);
        Notification::route('mail', $request->input('email'))
            ->notify(new TransferRequestNotification($code));

        return redirect()->back()->with('success', __('Transfer Request Sent'));
    }

    public function check(Account $account, CheckTransferRequest $request)
    {
        $this->authorize('accept', Transfer::class);
        try {
            $transfer = Transfer::where('code', $request->input('code'))->where(function ($q) use ($account) {
                return $q->where('email', $account->email)->orWhereNull('email');
            })->firstOrFail();

            return redirect()->route('transfer.show', [$account, $transfer->code]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', __('Transfer Cannot Be Found'));
        }
    }

    
    public function show(Account $account, $transfer)
    {
        $transfer = Transfer::where('code', $transfer)->where(function ($q) use ($account) {
            return $q->where('email', $account->email)->orWhereNull('email');
        })->firstOrFail();

        $this->authorize('show', $transfer);
        $sites = $account->sites()->whereHas('installs', function ($q) use ($transfer) {
            return $q->where('type', '!=', $transfer->install->type);
        })->get();
        $subscriptions = $account->subscriptions()->active()->available()->withCount('sites')->get();
        $totalActiveSubscriptions = $account->subscriptions()->active()->sum('quantity');

        return view('transfers.show', compact('account', 'transfer', 'sites', 'subscriptions', 'totalActiveSubscriptions'));
    }

    /**
     * Accept Transfer.
     *
     * @param  \App\Models\Account  $account
     *
     * @param  \App\Http\Requests\AcceptTransferRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Account $account, $transfer, AcceptTransferRequest $request)
    {

        $transfer = Transfer::where('code', $transfer)->where(function ($q) use ($account) {
            return $q->where('email', $account->email)->orWhereNull('email');
        })->firstOrFail();
        if ($request->input('transfer_way') == 'existing') {
            $site = $account->sites()->findOrFail($request->input('site_id'));
        } else {
            $site = $account->sites()->create($request->input('site'));
        }
        $install = Install::find($transfer->install_id);
        $install->update([
            'site_id' => $site->id,
        ]);

        $transfer->delete();

        return redirect()->route('installs.show', ['account' => $account, 'site' => $install->site, 'install' => $install])->with('success', __('Transfer Accepted'));
    }
}
