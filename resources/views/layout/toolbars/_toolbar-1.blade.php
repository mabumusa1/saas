@if (Route::currentRouteName() !== 'installs.show')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
            @include('layout/page-title/_default')
            @switch(Route::currentRouteName())
                @case('sites.index')
                    @can('create', App\Models\Site::class)
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">
                            <!--begin::Wrapper-->
                            <div class="me-4">
                                <div data-bs-toggle="tooltip" data-bs-placement="left">
                                    <button data-bs-toggle="modal"
                                    data-bs-target="#accept_transfer_modal" class="btn btn-sm btn-secondary fw-bolder">
                                        {{ __('Accept Transfer') }}
                                    </button>
                                </div>
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Wrapper-->
                            <div data-bs-toggle="tooltip" data-bs-placement="left">
                                <a href="{{ route('sites.create', $currentAccount->id) }}"
                                    class="btn btn-sm btn-primary fw-bolder">
                                    {{ __('Create') }}
                                </a>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Actions-->
                    @endcan
                @break

                @case('users.index')
                    @can('create', App\Models\User::class)
                        <!--begin::Actions-->
                        <div class="d-flex align-items-center py-1">
                            <!--begin::Wrapper-->
                            <!--end::Wrapper-->
                <!--begin::Wrapper-->
                <div data-bs-toggle="tooltip" data-bs-placement="left">
                    <button class="btn btn-sm btn-primary fw-bolder" data-bs-toggle="modal" data-bs-target="#add_user_modal">
                        {{ __('Add User') }}
                    </a>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Actions-->
            @endcan
                @break

                @default
            @endswitch
        </div>
        <!--end::Container-->
    </div>
    <!--end::Toolbar-->
@else
    @yield('toolbar')
@endif
