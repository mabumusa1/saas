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
                    <a href="{{ route('sites.index', $account->id) }}" class="menu-link px-3">
                        {{ $account->name }}
                    </a>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25" fill="none">
                            <path opacity="0.3"
                                  d="M8.9 21L7.19999 22.6999C6.79999 23.0999 6.2 23.0999 5.8 22.6999L4.1 21H8.9ZM4 16.0999L2.3 17.8C1.9 18.2 1.9 18.7999 2.3 19.1999L4 20.9V16.0999ZM19.3 9.1999L15.8 5.6999C15.4 5.2999 14.8 5.2999 14.4 5.6999L9 11.0999V21L19.3 10.6999C19.7 10.2999 19.7 9.5999 19.3 9.1999Z"
                                  fill="black"></path>
                            <path
                                d="M21 15V20C21 20.6 20.6 21 20 21H11.8L18.8 14H20C20.6 14 21 14.4 21 15ZM10 21V4C10 3.4 9.6 3 9 3H4C3.4 3 3 3.4 3 4V21C3 21.6 3.4 22 4 22H9C9.6 22 10 21.6 10 21ZM7.5 18.5C7.5 19.1 7.1 19.5 6.5 19.5C5.9 19.5 5.5 19.1 5.5 18.5C5.5 17.9 5.9 17.5 6.5 17.5C7.1 17.5 7.5 17.9 7.5 18.5Z"
                                fill="black"></path>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path opacity="0.3"
                              d="M6.45801 14.775L9.22501 17.542C11.1559 16.3304 12.9585 14.9255 14.605 13.349L10.651 9.39502C9.07452 11.0415 7.66962 12.8441 6.45801 14.775Z"
                              fill="black"></path>
                        <path
                            d="M9.19301 17.51C9.03401 19.936 6.76701 21.196 3.55701 21.935C3.34699 21.9838 3.12802 21.9782 2.92074 21.9189C2.71346 21.8596 2.52471 21.7484 2.37231 21.5959C2.2199 21.4434 2.10886 21.2545 2.04967 21.0472C1.99048 20.8399 1.98509 20.6209 2.034 20.411C2.772 17.201 4.03401 14.934 6.45801 14.775L9.19301 17.51ZM21.768 4.43697C21.9476 4.13006 22.0204 3.77232 21.9751 3.41963C21.9297 3.06694 21.7687 2.73919 21.5172 2.48775C21.2658 2.2363 20.9381 2.07524 20.5854 2.02986C20.2327 1.98449 19.8749 2.0574 19.568 2.23701C16.2817 4.20292 13.2827 6.61333 10.656 9.39998L14.61 13.354C17.395 10.7252 19.8037 7.72455 21.768 4.43697Z"
                            fill="black"></path>
                    </svg>
                </span>
                    <!--end::Svg Icon-->
                </span>
                <span class="menu-title">Sites</span>
            </a>
        </div>

        <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link"><span
                    class="menu-icon"><!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com006.svg-->
            <span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                   viewBox="0 0 24 24" fill="none">
            <path opacity="0.3"
                  d="M22 12C22 17.5 17.5 22 12 22C6.5 22 2 17.5 2 12C2 6.5 6.5 2 12 2C17.5 2 22 6.5 22 12ZM12 7C10.3 7 9 8.3 9 10C9 11.7 10.3 13 12 13C13.7 13 15 11.7 15 10C15 8.3 13.7 7 12 7Z"
                  fill="black"></path>
            <path
                d="M12 22C14.6 22 17 21 18.7 19.4C17.9 16.9 15.2 15 12 15C8.8 15 6.09999 16.9 5.29999 19.4C6.99999 21 9.4 22 12 22Z"
                fill="black"></path>
            </svg></span>
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
