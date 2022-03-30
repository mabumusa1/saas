<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptTransferRequest;
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

    /**
     * Accept Transfer.
     *
     * @param  \App\Models\Account  $account
     *
     * @param  \App\Http\Requests\AcceptTransferRequest  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Account $account, AcceptTransferRequest $request)
    {
        $this->authorize('accept', Transfer::class);
        try {
            $transfer = $account->transfers()->where('code', $request->input('code'))->firstOrFail();
            // TODO: Add code to move the install from one account to another
            return redirect()->back()->with('success', __('Transfer Accepted'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', __('Transfer Cannot Be Found'));
        }
    }
}
