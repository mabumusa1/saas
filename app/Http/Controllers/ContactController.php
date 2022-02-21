<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Account $account
     * @return \Illuminate\View\View
     */
    public function index(Account $account)
    {
        return view('contact.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Account $account
     * @param  \App\Models\Site  $site
     * @return \Illuminate\View\View
     */
    public function edit(Account $account, Contact $contact)
    {
        return view('contact.edit', ['contact' => $contact]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Site  $site
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Account $account, UpdateContactRequest $request, Contact $contact)
    {
        return redirect(route('contact.index'))->with('status', 'Contact has been updated');
    }
}
