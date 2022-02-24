<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="{{ theme()->printHtmlClasses('toolbar-container', false) }} d-flex flex-stack">
        @if (theme()->getOption('layout', 'page-title/display') && theme()->getOption('layout', 'header/left') !== 'page-title')
            {{ theme()->getView('layout/page-title/_default') }}
        @endif

        @switch(Route::currentRouteName())
            @case('sites.index')
                    <!--begin::Actions-->
                    <div class="d-flex align-items-center py-1">
                        <!--begin::Wrapper-->
                        <div class="me-4">
                            <div data-bs-toggle="tooltip" data-bs-placement="left">
                                <a href="#" class="btn btn-sm btn-secondary fw-bolder">
                                    Accept Transfer
                                </a>
                            </div>
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Wrapper-->
                        <div data-bs-toggle="tooltip" data-bs-placement="left">
                            <a href="{{ route('sites.create', $currentAccount->id) }}" class="btn btn-sm btn-primary fw-bolder">
                                Create
                            </a>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Actions-->
                @break

            @case('users.index')
             <!--begin::Actions-->
             <div class="d-flex align-items-center py-1">
                <!--begin::Wrapper-->
                <!--end::Wrapper-->

                <!--begin::Wrapper-->
                <div data-bs-toggle="tooltip" data-bs-placement="left">
                    <a href="{{ route('users.create', $currentAccount->id) }}" class="btn btn-sm btn-primary fw-bolder">
                        Add User
                    </a>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Actions-->
                @break
            @default

        @endswitch
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
