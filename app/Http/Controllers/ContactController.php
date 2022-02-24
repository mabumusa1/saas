<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateContactRequest;
use App\Models\Account;
use App\Models\Contact;
use Illuminate\Http\Request;
<<<<<<< HEAD
=======
use Session;
>>>>>>> 8ace9bb3064931a44da8111f248fc97905aa5874

class ContactController extends Controller
{
    /**
     * ContactController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Contact::class, 'contact');
    }

    /**
     * @param Account $account
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Account $account)
    {
        return view('contact.index');
    }

    /**
     * @param Account $account
     * @param Contact $contact
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Account $account, Contact $contact)
    {
        return view('contact.edit', compact('account', 'contact'));
    }

    /**
     * @param Account $account
     * @param UpdateContactRequest $request
     * @param Contact $contact
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Account $account, UpdateContactRequest $request, Contact $contact)
    {
        $data = $request->all();

        $contact->update([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => isset($data['phone']) ? $data['phone'] : null,
        ]);
        Session::flash('status', 'Contact has been updated!');

        return redirect(route('contacts.index', ['account' => $account]));
    }
}
