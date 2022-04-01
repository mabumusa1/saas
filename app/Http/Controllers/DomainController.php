<?php

namespace App\Http\Controllers;

use App\Events\SetDomainPrimaryEvent;
use App\Events\SetDomainRedirectEvent;
use App\Http\Requests\DomainRedirectRequest;
use App\Http\Requests\StoreDomainRequest;
use App\Models\Account;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index(Account $account, Site $site, Install $install)
    {
        return view('installs.domains.index', ['account' => $account, 'site' => $site, 'install' => $install]);
    }

    public function store(Account $account, Site $site, Install $install, StoreDomainRequest $request)
    {
        if ($request->has('isValidation')) {
            return response()->json(['valid' => true]);
        }

        $data = $request->safe()->all();
        $domain = Domain::create([
            'install_id' => $install->id,
            'name' => $data['name'],
            'primary' => false,
        ]);

        return redirect()->route('domains.index', ['account' => $account, 'site' => $site, 'install' => $install])->with('success', __('Domain was added to your install'));
    }

    public function destroy(Account $account, Site $site, Install $install, Domain $domain)
    {
        if ($domain->isBuiltIn) {
            abort(403, __('You can not delete the built in domain'));
        }

        if ($domain->primary) {
            $newPrimary = Domain::find($install->cname)->first();
            $newPrimary->primary = true;
            $newPrimary->save();
        }

        $domain->delete();

        return redirect()->route('domains.index', ['account' => $account, 'site' => $site, 'install' => $install])->with('success', __('Domain was deleted'));
    }

    public function redirect(Account $account, Site $site, Install $install, DomainRedirectRequest $request)
    {
        $data = $request->validated();
        $sourceDomain = Domain::find($data['domain']);
        if (! $request->has('dest')) {
            $sourceDomain->redirect_to = '';
            $sourceDomain->save();
        } else {
            $destDomain = Domain::find($data['dest']);
            $sourceDomain->redirect_to = $destDomain->name;
            $sourceDomain->save();
        }

        SetDomainRedirectEvent::dispatch($sourceDomain);

        return redirect()->route('domains.index', ['account' => $account, 'site' => $site, 'install' => $install])->with('success', __('Redirect is set'));
    }

    public function setPrimary(Account $account, Site $site, Install $install, Domain $domain)
    {
        $oldPrimary = $install->domains->where('primary', true)->first();
        $oldPrimary->primary = false;
        $oldPrimary->save();

        $domain->primary = true;
        $domain->save();

        SetDomainPrimaryEvent::dispatch($domain);

        return redirect()->route('domains.index', ['account' => $account, 'site' => $site, 'install' => $install])->with('success', __('Domain set as primary'));
    }
}
