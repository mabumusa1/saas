<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateContactRequest;
use App\Models\Account;
use App\Models\Contact;
use Illuminate\Http\Request;
use Session;

class ContactController extends Controller
{
    /**
     * Create the controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Site::class, 'site');
    }

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
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\View\View
     */
    public function edit(Account $account, Contact $contact)
    {
        return view('contact.edit', compact('account', 'contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Account $account
     * @param  \App\Http\Requests\UpdateContactRequest  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Account $account, UpdateContactRequest $request, Contact $contact)
    {
        $data = $request->all();

        $this->validate($request, [
            'first_name'  => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email' => 'required|string|max:255',
        ]);

        $contact->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => isset($data['phone']) ? $data['phone'] : null,
        ]);
        Session::flash('message', 'Contact has been updated!');

        return redirect(route('contacts.index', ['account' => $account]));
    }
}
