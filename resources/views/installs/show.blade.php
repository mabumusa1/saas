@extends('installs.layout.default')
@section('install_module')
    <div class="alert alert-dismissible alert-primary d-flex align-items-center p-5 mb-10">
        <!--begin::Icon-->
        <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
            {!! get_svg_icon('skin/media/icons/duotune/general/gen002.svg') !!}
        </span>
        <!--end::Icon-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column">
            <!--begin::Title-->
            <h4 class="mb-2 dark">{{ __('Go live checklist') }}</h4>
            <!--end::Title-->
            <div class="d-flex">
                <!--begin::Content-->
                <span>{{ __('It is easy to lose track of all the required and optimal task for a site launcher. Use our checklist for keeping track. Find it any time in your site details links on the left.') }}</span>
                <!--end::Content-->
                <div class="flex-lg-row-auto ms-4">
                    <a href="#" class="btn btn-primary">{{ __('See the checklist') }}</a>
                </div>
            </div>
        </div>
        <!--end::Wrapper-->
        <!--begin::Close-->
        <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
            data-bs-dismiss="alert">
            <i class="bi bi-x fs-1 text-primary"></i>
        </button>
        <!--end::Close-->
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 card-title">{{ __('Overview') }}</h2>
            <div class="card-toolbar">
                <a class="btn btn-primary btn-icon btn-sm px-4 px-lg-6 me-2 me-lg-3">
                    {!! get_svg_icon('skin/media/icons/duotone/Files/Cloud-download.svg') !!}
                </a>
                <a class="btn btn-primary btn-icon btn-sm px-4 px-lg-6 me-2 me-lg-3">
                    {!! get_svg_icon('skin/media/icons/duotone/General/Lock.svg', 'svg-icon-2x') !!}
                </a>
                <a id="btn-delete" class="btn btn-danger btn-sm btn-icon px-4 px-lg-6 me-2 me-lg-3">
                    {!! get_svg_icon('skin/media/icons/duotone/General/Trash.svg', 'svg-icon-2x') !!}
                </a>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Alert-->
            <div class="alert alert-dismissible bg-warning d-flex flex-column flex-sm-row p-5 mb-10">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-2hx svg-icon-dark me-4 mb-5 mb-sm-0">
                    {!! get_svg_icon('skin/media/icons/duotone/Code/Warning-2.svg', 'svg-icon-2x') !!}
                </span>
                <!--end::Icon-->

                <!--begin::Wrapper-->
                <div class="d-flex flex-column text-dark pe-0 pe-sm-10">
                    <!--begin::Content-->
                    <span>Install status should go here</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Alert-->

            @if ($install->owner === 'transferable')
                <div class="card card-bordered border-primary mb-5">
                    <div class="card-header bg-gray-200">
                        <h3 class="card-title">{{ __('Transferable install') }}</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#transfer_site_modal">
                                {{ __('Transfer Install') }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item border-0">Demo link:</li>
                            <li class="list-group-item border-0">User: demo</li>
                            <li class="list-group-item border-0 d-flex">Password: {!! get_svg_icon('skin/media/icons/duotone/General/Edit.svg', 'ms-2') !!}</li>
                        </ul>
                        <hr />
                        <p>
                            {{ __('Traffic to this install is restricted and password-protected. To unlock, transfer the
                                                    install to another account or convert to a billable site. Learn more about
                                                    transferable sites') }}
                        </p>
                    </div>
                </div>
            @endif

            <div class="card card-bordered border-gray-500">
                <div class="card-header bg-gray-200">
                    <h2 class="mb-0 card-title">{{ __('Need help migrating your Mautic to Steer Campaign') }}</h2>
                </div>
                <div class="card-body">
                    <p>{{ __('We are building an automated migration plugin that allows you to migrate your Mautic to Steer Campaign, right now you can get in touch with our support team to migrate your Mautic for free') }}
                    </p>
                    <a class="btn btn-sm btn-primary px-4 px-lg-6 me-2 me-lg-3">
                        {{ __('Get started') }}
                    </a>
                </div>
            </div>
            <div class="card mt-6 bg-light-primary">
                <div class="card-header bg-gray-200">
                    <h3 class="card-title">{{ __('Install stats') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">{{ __('Primary domain:') }} </span> <a
                                    href="">{{ __('Set primary domain') }}</a></p>
                            <p class="fw-bold">{{ __('Technical contact:') }} </span> <a
                                    href="">{{ $install->contact->fullName }}</a></p>
                        </div>
                        <div class="col">
                            <p class="fw-bold">{{ __('CNAME:') }} </span> <a
                                    href="https://{{ $install->cname }}">{{ $install->cname }}</a></p>
                            <p class="fw-bold">{{ __('IP Address:') }} </span> {{ $install->ip }}</p>

                            <p class="fw-bold">{{ __('Created at:') }} </span> <a
                                    href="">{{ $install->created_at }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <form id="delete_form" method="post" action="{{ route('installs.destroy', ['account' => $currentAccount, 'site' => $site, 'install' => $install ]) }}">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('modals')
    @include('installs.partials.modals', [
        'install_id' => $install->id,
        'installs' => $installs,
    ])
@endpush

@push('scripts')
    <script>
        document.querySelector('#btn-delete').addEventListener('click', function(e) {
            e.preventDefault();
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
                    document.querySelector('#delete_form').submit();
                }
            })
        });
    </script>
@endpush
