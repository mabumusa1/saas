<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcceptTransferRequest;
use App\Http\Requests\StoreTransferRequest;
use App\Http\Requests\UpdateTransferRequest;
use App\Models\Account;
use App\Models\Transfer;
use App\Notifications\TransferRequestNotification;
use Hash;
use Illuminate\Notifications\AnonymousNotifiable;
use Notification;
use Str;

class TransferController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransferRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransferRequest $request, Account $account)
    {
        $code = Str::random(32);
        $data = $request->validated();
        $data['code'] = Hash::make($code);
        $account->transfers()->create($data);
        Notification::route('mail', $request->input('email'))
            ->notify(new TransferRequestNotification($account, $code));

        return redirect()->route('installs.show', ['account' => $account, 'install' => $request->input('install_id')])->with('success', __('Transfer Request Sent'));
    }

    public function accept(AcceptTransferRequest $request, Account $account)
    {
        $transfer = $account->transfers()->where('code', $request->input('code'))->first();
        if (Hash::check($request->input('code'), $transfer->code)) {
            return redirect()->back()->with('success', __('Transfer Accepted'));
        }

        return redirect()->back()->with('error', __('Transfer Cannot Be Found'));
    }
}
