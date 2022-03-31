@extends('installs.layout.default')
@section('install_module')
<div class="card">
    <div class="card-header">
        <h2 class="mb-0 card-title">{{ __('Domains') }}</h2>
    </div>
    <div class="card-body">
        <p>{{ __('Manage your domains, or setup simple redirects between your domains') }}</p>
        <div class="card card-borded">
            <div class="card-header">
                <h2 class="mb-0 card-title">{{ __('Domains & Redirect') }}</h2>
                <div class="card-toolbar">
                    <a href="{{ route('domains.create', [$account, $site, $install]) }}" class="btn btn-primary">{{ __('Add Domain') }}</a>
                </div>        
            </div>
            <div class="card-body">
                <h3>{{ __('Primary Domain') }}</h3>
                <p>{{ __('Properly setting the primary domain helps our system ensure your site serves traffic as expected. This should be the main domain that hosts Mautic') }}</p>
                <div class="table-responsive">
                    <table class="table gs-7 gy-7 gx-7">
                        <thead>
                            <tr class="fw-bold fs-6 bg-gray-200 border-bottom border-gray-200">
                             <th>{{ __('Domain') }}</th>
                             <th>{{ __('Status') }}</th>
                             <th>{{ __('Info') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <hr class="mb-5">
                <h3>{{ __('Redirects and others') }}</h3>
                <p>{{ __('Set up simple redirects between your domains. To manage advanced URL redirects. visit ') }}<a href="#">{{ __('redirect rules') }}</a></p>
                <div class="table-responsive">
                    <table class="table gs-7 gy-7 gx-7">
                        <thead>
                            <tr class="fw-bold fs-6 bg-gray-200 border-bottom border-gray-200">
                             <th>{{ __('Domain') }}</th>
                             <th>{{ __('Redirect to') }}</th>
                             <th>{{ __('Status') }}</th>
                             <th>{{ __('Info') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <hr class="mb-5">
                <h3>{{ __('DNS details') }}</h3>
                <p>{{ __('These are the DNS record details you will need to point your domain at Steer Campagin ') }}<a href="#">{{ __('Learn how to configure DNS') }}</a></p>
                <div class="table-responsive">
                    <table class="table gs-7 gy-7 gx-7">
                        <thead>
                            <tr class="fw-bold fs-6 bg-gray-200 border-bottom border-gray-200">
                             <th>{{ __('Type') }}</th>
                             <th>{{ __('Value') }}</th>
                             <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        
        </div>
    </div>
@endsection