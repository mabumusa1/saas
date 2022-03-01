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
                                    {{ __('Accept Transfer') }}
                                </a>
                            </div>
                        </div>
                        <!--end::Wrapper-->

                        <!--begin::Wrapper-->
                        <div data-bs-toggle="tooltip" data-bs-placement="left">
                            <a href="{{ route('sites.create', $currentAccount->id) }}" class="btn btn-sm btn-primary fw-bolder">
                                {{ __('Create') }}
                            </a>
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Actions-->
                @break

            @case('sites.show')
                <div class="py-1">
                    <a>
                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Stockholm-icons-/-Navigation-/-Arrow-left" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
                                <rect id="Rectangle" fill="#000000" opacity="0.5" transform="translate(12.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-12.000000, -12.000000) " x="11" y="5" width="2" height="14" rx="1"></rect>
                                <path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" id="Path-94" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997) "></path>
                            </g>
                        </svg>
                    </a>
                </div>
                @break

            @case('users.index')
             <!--begin::Actions-->
             <div class="d-flex align-items-center py-1">
                <!--begin::Wrapper-->
                <!--end::Wrapper-->

                <!--begin::Wrapper-->
                <div data-bs-toggle="tooltip" data-bs-placement="left">
                    <a href="{{ route('users.create', $currentAccount->id) }}" class="btn btn-sm btn-primary fw-bolder">
                        {{ __('Add User') }}
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
