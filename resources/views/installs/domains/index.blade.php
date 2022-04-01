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
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#create_domain_modal">{{ __('Add Domain') }}</button>
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
                            <tr>
                                <td>{{ $install->primaryDomain()->name }}</td>
                                <td>
                                    @include('installs.domains.partials.status', ['domain' => $install->primaryDomain()])
                                </td>
                                <td>
                                    <p class="text-wrap">Say if there is a proxy or not, other relvant info</p>
                                </td>
                            </tr>
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
                             <th class="min-w-100px">{{ __('Domain') }}</th>
                             <th class="min-w-100px"> {{ __('Redirect to') }}</th>
                             <th>{{ __('Status') }}</th>
                             <th class="min-w-200px">{{ __('Info') }}</th>
                             <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($install->domains as $domain)
                                @if($domain->id === $install->primaryDomain()->id)
                                    @continue
                                @endif
                                <tr>
                                    <td>
                                        {{ $domain->name }}
                                    </td>
                                    <td>
                                        {{ $domain->redirect_to }}
                                    </td>
                                    <td>@include('installs.domains.partials.status', ['domain' => $domain])</td>
                                    <td><p class="text-wrap">Say if there is a proxy or not, other relvant info</p></td>
                                    <td>
                                        <!--begin::Trigger-->
                                        <button type="button" class="btn btn-primary btn-sm btn-icon"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                            <span class="svg-icon svg-icon-5"><i
                                                    class="bi bi-three-dots"></i></span>
                                        </button>                                        
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="#redirectModal" data-bs-toggle="modal" data-bs-target="#redirectModal" data-bs-domainName="{{ $domain->name }}" data-bs-domainId="{{ $domain->id }}" class="menu-link px-3">
                                                {{ __('Add redirect') }}
                                            </a>
                                            <a href="#" class="menu-link px-3">
                                                {{ __('Set as primary') }}
                                            </a>
                                            @if(!$domain->isBuiltIn)
                                            <a data-target=".delete_form{{ $domain->id }}" class="menu-link px-3 btn-delete">{{ __('Delete') }}</a><br/>
                                            <form
                                            action="{{ route('domains.destroy', [$account->id, $site->id, $install->id, $domain->id]) }}"
                                            class="delete_form{{ $domain->id }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
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
                            <tr>
                                <td>{{ __('CNAME') }}</td>
                                <td>{{ $install->cname }}</td>
                                <td>
                                    <span class="svg-icon svg-icon-2 svg-icon-success">
                                        {!! get_svg_icon('skin/media/icons/duotone/Navigation/Check.svg') !!}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>{{ __('A') }}</td>
                                <td>{{ $install->ip }}</td>
                                <td>
                                    <span class="svg-icon svg-icon-2 svg-icon-success">
                                        {!! get_svg_icon('skin/media/icons/duotone/Navigation/Check.svg') !!}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        
        </div>
    </div>
@endsection

@push('modals')
    @include('installs.domains.partials.create')
    @include('installs.domains.partials.redirect')
@endpush

@push('scripts')
<script>
    var deleteBtn = document.querySelectorAll('.btn-delete');
    deleteBtn.forEach(function(button) {
        button.addEventListener('click', function(e) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector(button.getAttribute('data-target')).submit();
                }
            })
        });
    })

    var redirectModal = document.getElementById('redirectModal')
    var redirectform = document.getElementById('redirect-form')
    redirectModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget
        var sourceDomain = button.getAttribute('data-bs-domainName')
        var sourceId = button.getAttribute('data-bs-domainId')
        var sourceTxt = redirectModal.querySelector('.source')
        var dest = redirectModal.querySelector(".dest option[value='" + sourceId + "']")
        dest.remove()
        var sourceIdField = redirectModal.querySelector('.sourceId')
        sourceIdField.value = sourceId
        sourceTxt.value = sourceDomain    
        const form = document.getElementById('redirect-form')
    })    
    // Submit button handler
    const submitRedirectButton = document.getElementById('btn-redirect-submit');
    submitRedirectButton.addEventListener('click', function(e) {
        const form = document.getElementById('site-form')
        // Prevent default button action
        e.preventDefault();
        if(redirectModal.querySelector(".dest").value === 'null'){
            redirectModal.querySelector(".dest").value=""
        }
        redirectform.submit();
    });

</script>


@endpush
    
