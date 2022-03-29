<x-base-layout>
    @section('toolbar')
        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack h-100">
                <div
                    class="align-items-center border border-bottom-0 border-left-0 border-right-2 border-top-0 col-3 d-flex h-100 justify-content-between">
                    <span class="text-black">{{ $install->name }}</span>
                    <span class="svg-icon svg-icon-5 ms-1 me-2 svg-icon-md-1">{!! get_svg_icon('skin/media/icons/duotone/General/Other2.svg') !!}</span>
                </div>
                <div class="col col-3 border border-bottom-0 border-left-0 border-right-2 border-top-0 h-100 d-flex">
                    <!--begin::Trigger-->
                    <button type="button" class="btn ps-3 pe-3" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-start">
                        <span class="badge badge-info me-2">{{ strtoupper($install->type) }}</span>
                        {{ $install->name }}
                        <span class="svg-icon svg-icon-5 ms-1 me-0 svg-icon-md-1">{!! get_svg_icon('skin/media/icons/duotone/Navigation/Angle-down.svg') !!}</span>
                    </button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-225px"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item bg-dark text-light">
                            <a class="menu-link px-3 d-flex justify-content-between disabled">
                                <div>
                                    <span class="badge badge-info me-3">{{ strtoupper($install->type) }}</span>
                                    {{ $install->name }}
                                </div>
                                <span
                                    class="svg-icon svg-icon-5 ms-3 me-0 svg-icon-md-1 svg-icon-light">{!! get_svg_icon('skin/media/icons/duotune/arrows/arr085.svg') !!}</span>
                            </a>

                        </div>
                        @if(!in_array('prd', $envs))
                        <div class="menu-item bg-light-primary text-light">
                            <a class="menu-link px-3 d-flex justify-content-between disabled" href="{{ route('installs.create', ['account' => $currentAccount, 'site' => $site]) }}?env=prd">Add Production install</a>
                        </div>
                        @endif
                        @if(!in_array('stg', $envs))
                        <div class="menu-item bg-light-primary text-light">
                            <a class="menu-link px-3 d-flex justify-content-between disabled" href="{{ route('installs.create', ['account' => $currentAccount, 'site' => $site]) }}?env=stg">Add Staging install</a>
                        </div>
                        @endif
                        @if(!in_array('dev', $envs))
                        <div class="menu-item bg-light-primary text-light">
                            <a class="menu-link px-3 d-flex justify-content-between disabled" href="{{ route('installs.create', ['account' => $currentAccount, 'site' => $site]) }}?env=dev">Add development install</a>
                        </div>
                        @endif
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <div class="col d-flex justify-content-between align-items-center ms-3">
                    <div class="d-inline-flex">
                        <a href="" class="me-4">WP Admin<span
                                class="svg-icon svg-icon-5 me-0 svg-icon-md-1">{!! get_svg_icon('skin/media/icons/duotune/arrows/arr095.svg') !!}</span></a>
                        <a href="">phpMyAdmin<span
                                class="svg-icon svg-icon-5 me-0 svg-icon-md-1">{!! get_svg_icon('skin/media/icons/duotune/arrows/arr095.svg') !!}</span></a>
                    </div>
                    <button class="btn border border-2 border-primary text-primary">Copy install</button>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
    @endsection
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="container p-0">
        <div class="row">
            <div class="col-3">
                <div class="card">

                    <div class="card-body p-0">
                        <span class="border border-left-5 border-primary d-block p-5">{{ __('Production') }}</span>
                        <span
                            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400 text-info">{{ __('Overview') }}</span>
                        <span
                            class="d-block p-2 ps-7 border border-bottom-1 border-top-0 border-gray-400">{{ __('Domains') }}</span>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="alert alert-dismissible bg-light-primary d-flex flex-column flex-sm-row p-5 mb-10">
                    <!--begin::Icon-->
                    <span class="svg-icon svg-icon-2hx svg-icon-dark me-4 mb-5 mb-sm-0">
                        {!! get_svg_icon('skin/media/icons/duotone/Communication/RSS.svg') !!}
                    </span>
                    <!--end::Icon-->

                    <!--begin::Wrapper-->
                    <div class="d-flex flex-column text-dark pe-0 pe-sm-10">
                        <!--begin::Title-->
                        <h4 class="mb-2 dark">{{ __('Go live checklist') }}</h4>
                        <!--end::Title-->
                        <div class="d-flex">
                            <!--begin::Content-->
                            <span>{{ __('It is easy to lose track of all the required and optimal task for a site launcher. Use
                                                                                                                                                                                                                                    our checklist for keeping track. Find it any time in your site details links on the
                                                                                                                                                                                                                                    left.') }}</span>
                            <!--end::Content-->
                            <div class="flex-lg-row-auto ms-4">
                                <button class="btn btn-primary">{{ __('See the checklist') }}</button>
                            </div>
                        </div>
                    </div>
                    <!--end::Wrapper-->

                    <!--begin::Close-->
                    <button type="button"
                        class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                        data-bs-dismiss="alert">
                        <span class="svg-icon svg-icon-2x svg-icon-dark">
                            {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                        </span>
                    </button>
                    <!--end::Close-->
                </div>
                <!--end::Alert-->
                <div class="d-flex justify-content-between align-items-center mb-10">
                    <h2 class="mb-0">Overview</h2>
                    <div>
                        <button class="btn btn-primary btn-icon">
                            <span class="svg-icon svg-icon-1">
                                {!! get_svg_icon('skin/media/icons/duotone/Files/Cloud-download.svg') !!}
                            </span>
                        </button>
                        <button class="btn btn-primary btn-icon">
                            {!! get_svg_icon('skin/media/icons/duotone/General/Lock.svg', 'svg-icon-2x') !!}
                        </button>
                        <button class="btn btn-primary btn-icon">
                            {!! get_svg_icon('skin/media/icons/duotone/General/Trash.svg', 'svg-icon-2x') !!}
                        </button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Transferable environment</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#transfer_site_modal">
                                Transfer Envoironment
                            </button>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
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
                        <span>{{ __('The alert component can be used to highlight certain parts of your page for higher content visibility.') }}</span>
                        <!--end::Content-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Alert-->
                <!--begin::Alert-->
                <div class="alert alert-dismissible d-flex flex-column p-0 mb-10">
                    <div class="align-items-center d-flex justify-content-between bg-primary ps-5">
                        <h4 class="mb-0 light">{{ __('This is an alert') }}</h4>
                        <button type="button"
                            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                            data-bs-dismiss="alert">
                            <span class="svg-icon svg-icon-2x svg-icon-light"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                        transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                        transform="rotate(45 7.41422 6)" fill="black"></rect>
                                </svg></span>
                        </button>
                    </div>

                    <div class="border border-2 border-gray-300 p-4">
                        <!--begin::Wrapper-->
                        <span>{{ __('The alert component can be used to highlight certain parts of your page for higher content visibility.') }}</span>
                        <!--end::Content-->
                        <div class="mt-2">
                            <button class="btn btn-primary">{{ __('Get started') }}</button>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--begin::Close-->

                    <!--end::Close-->
                </div>
                <!--end::Alert-->
                <div class="card card-bordered">
                    <div class="card-body">
                        <h3 class="card-title">
                            {{ __('PHP Test Driver') }}
                        </h3>
                        <div class="d-flex justify-content-between">
                            <p>
                                {{ __('Preview your website on PHP 8.0 without actually changing the PHP version. Visitors will continue to see the current PHP version of your barehsite in their hrawsers Clear vaur conkies to end the nraview') }}
                            </p>
                            <div class="flex-column-auto">
                                <button class="btn btn-primary">{{ __('Preview PHP 8.0') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-6 bg-light-primary">
                    <div class="card-body">
                        <h3 class="card-title">
                            {{ __('Install stats') }}
                        </h3>
                        <div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span>{{ __('Primary domain:') }} </span> <a
                                        href="">{{ __('Set primary domain') }}</a>
                                </div>
                                <div>
                                    <span>{{ __('SSH Login:') }} </span> <span>test@domain.com</span>
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13.9466 0.215088H4.45502C3.44455 0.215088 2.62251 1.0396 2.62251 2.05311V2.62219H2.04736C1.03688 2.62219 0.214844 3.44671 0.214844 4.46078V13.9469C0.214844 14.9605 1.03688 15.785 2.04736 15.785H11.5393C12.553 15.785 13.3776 14.9605 13.3776 13.9469V13.3779H13.9466C14.9604 13.3779 15.7852 12.5534 15.7852 11.5393V2.05306C15.7852 1.0396 14.9604 0.215088 13.9466 0.215088ZM12.2526 13.9469C12.2526 14.3402 11.9326 14.6599 11.5393 14.6599H2.04736C1.65732 14.6599 1.33984 14.3402 1.33984 13.9469V4.46073C1.33984 4.06743 1.65738 3.74714 2.04736 3.74714H3.18501H11.5393C11.9326 3.74714 12.2526 4.06737 12.2526 4.46073V12.8153V13.9469ZM14.6602 11.5392C14.6602 11.9325 14.3402 12.2528 13.9466 12.2528H13.3775V4.46073C13.3775 3.44671 12.553 2.62214 11.5392 2.62214H3.74746V2.05306C3.74746 1.65976 4.06499 1.34003 4.45497 1.34003H13.9466C14.3402 1.34003 14.6602 1.65976 14.6602 2.05306V11.5392Z"
                                            fill="#B5B5C3" />
                                    </svg>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <span>{{ __('Technical contact:') }}</span> <span>Mohammad
                                        AbuMusa</span>
                                </div>
                                <div>
                                    <span>{{ __('Created:') }}</span> <span>Feb 1, 2022 7:03 AM UTC</span>
                                </div>
                            </div>
                            <div class="mt-2">
                                <a href="">{{ __('View DNS Details') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-6">
                    <div class="col col-6">
                        <div class="card card-bordered">
                            <div class="card-body">
                                <h3 class="card-title">{{ __('Visitors') }}</h3>
                                <p class="mt-20 text-center">{{ __('Not Available') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col col-6">
                        <div class="card card-bordered">
                            <div class="card-body">
                                <h3 class="card-title">{{ __('Bandwidth') }}</h3>
                                <p class="mt-20 text-center">{{ __('Not Available') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col col-12 mt-6">
                        <div class="card card-bordered">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h3 class="card-title">{{ __('Storage') }}</h3>
                                    <a href="">{{ __('View Storage Details') }}</a>
                                </div>
                                <p class="mt-20 text-center">{{ __('Not Available') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    @include('installs.models', ['install_id' => $install->id])
    @push('scripts')
        <style>
            .btn-action {
                border-radius: 0%;
            }

        </style>
    @endpush
</x-base-layout>
