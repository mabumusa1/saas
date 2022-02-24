{{--begin::Aside Menu--}}
@php
    $menu = bootstrap()->getAsideMenu();
    \App\Core\Adapters\Menu::filterMenuPermissions($menu->items);
@endphp

<div
    class="hover-scroll-overlay-y my-5 my-lg-5"
    id="kt_aside_menu_wrapper"
    data-kt-scroll="true"
    data-kt-scroll-activate="{default: false, lg: true}"
    data-kt-scroll-height="auto"
    data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer"
    data-kt-scroll-wrappers="#kt_aside_menu"
    data-kt-scroll-offset="0"
>

    <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
        <div class="row">
            <div class="col d-flex justify-content-center">
                <p class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                    <span class="symbol-label font-size-h5 font-weight-bold">C</span>
                </p>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col d-flex justify-content-center">
                <h5 class="text-white">{{  \Illuminate\Support\Str::words($currentAccount->name, 2, '...')   }} </h5>
            </div>
        </div>
        <!--begin::Trigger-->
        <button type="button" class="btn btn-primary w-100"
                data-kt-menu-trigger="click"
                data-kt-menu-placement="bottom-start">
            Switch Accounts
            <span class="svg-icon svg-icon-5 rotate-180 ms-3 me-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                        fill="black"></path>
                </svg>
            </span>
        </button>
        <!--end::Trigger-->
        <!--begin::Menu-->
        <div
            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
            data-kt-menu="true">
        @foreach ( Auth::user()->accounts as $account)
            <!--begin::Menu item-->
                <div class="menu-item px-3">
                    @if (Illuminate\Support\Str::contains(Route::currentRouteName(), ['sites.edit', 'groups.edit', 'contacts.edit', 'users.edit']))
                        <a href="{{ route('sites.index', $account->id) }}" class="menu-link px-3">
                            {{ $account->name }}
                        </a>
                    @else
                        <a href="{{ route(Route::currentRouteName(), $account->id) }}" class="menu-link px-3">
                            {{ $account->name }}
                        </a>
                    @endif
                </div>
                <!--end::Menu item-->

            @endforeach
        </div>
    </div>

    {{--begin::Menu--}}
    <div
        class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
        id="#kt_aside_menu" data-kt-menu="true">
        <div class="menu-item">
            <a class="menu-link" href="{{ route('dashboard', $currentAccount->id) }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: assets/media/icons/duotune/art/art002.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Stockholm-icons-/-Layout-/-Layout-grid" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                <rect id="Rectangle-7" fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="1"></rect>
                                <path d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z" id="Combined-Shape" fill="#000000"></path>
                            </g>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Dashboard</span>
            </a>
        </div>

        <div class="menu-item">
            <a class="menu-link" href="{{ route('sites.index', $currentAccount->id) }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: assets/media/icons/duotune/art/art003.svg-->
                    <span class="svg-icon svg-icon-2">
                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Stockholm-icons-/-Layout-/-Layout-top-panel-6" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                <rect id="Rectangle-7-Copy" fill="#000000" x="2" y="5" width="19" height="4" rx="1"></rect>
                                <rect id="Rectangle-7-Copy-4" fill="#000000" opacity="0.3" x="2" y="11" width="19" height="10" rx="1"></rect>
                            </g>
                        </svg>
                </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Sites</span>
            </a>
        </div>

        <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span
                    class="menu-icon"><!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com006.svg-->
            <span class="svg-icon svg-icon-2">
                <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <g id="Stockholm-icons-/-General-/-User" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <polygon id="Shape" points="0 0 24 0 24 24 0 24"></polygon>
                        <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" id="Mask" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                        <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" id="Mask-Copy" fill="#000000" fill-rule="nonzero"></path>
                    </g>
                </svg>
        </span>
                    <!--end::Svg Icon--></span><span class="menu-title">Users</span><span
                    class="menu-arrow"></span></span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('users.index', $currentAccount->id) }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">Account Users</span>
                    </a>
                </div>
                <div class="menu-item"><a class="menu-link" href="{{ route('contacts.index', $currentAccount->id) }}"><span
                            class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Techincal Contacts</span></a>
                </div>
                <div class="menu-item"><a class="menu-link" href="https://sc.ddev.site/activity_log"><span
                            class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Activity Log</span></a>
                </div>
            </div>
        </div>
        {{-- {!! $menu->build() !!} --}}
    </div>
    {{--end::Menu--}}
</div>
{{--end::Aside Menu--}}
