<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
        <!--begin::Menu item-->
        <div class="menu-item px-3">
            <div class="menu-content d-flex align-items-center px-3">
                
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <!--begin::Avatar-->
                <div class="symbol symbol-50px me-5">
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                </div>
                <!--end::Avatar-->
                @endif
    
                <!--begin::Username-->
                <div class="d-flex flex-column">
                    <div class="fw-bolder d-flex align-items-center fs-5">
                        {{ Auth::user()->name }}
                    </div>
                    <a href="#" class="fw-bold text-muted text-hover-primary fs-7">{{ auth()->user()->email }}</a>
                </div>
                <!--end::Username-->
            </div>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->

        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="{{ route('profile.show') }}" class="menu-link px-5">
                {{ __('Profile') }}
            </a>
        </div>
        <!--end::Menu item-->

        <!--begin::Menu item-->
        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
        <div class="menu-item px-5">
            <a href="{{ route('api-tokens.index') }}" class="menu-link px-5">
                {{ __('API Tokens') }}
            </a>
        </div>
        @endif
        <!--end::Menu item-->

        <!--begin::Menu separator-->
        <div class="separator my-2"></div>
        <!--end::Menu separator-->

        <!--begin::Menu item-->
        <div class="menu-item px-5">
            <a href="#" data-action="{{ theme()->getPageUrl('logout') }}" data-method="post" data-csrf="{{ csrf_token() }}" data-reload="true" class="button-ajax menu-link px-5">
                {{ __('Sign Out') }}
            </a>
        </div>
        <!--end::Menu item-->
</div>
<!--end::Menu-->