{{--begin::Aside Menu--}}
<div
    class="hover-scroll-overlay-y my-5 my-lg-5"
    id="kt_aside_menu_wrapper"
    data-kt-scroll="true"
    data-kt-scroll-activate="{default: false, lg: true}"
    data-kt-scroll-height="auto"
    data-kt-scroll-dependencies="#kt_aside_logo"
    data-kt-scroll-wrappers="#kt_aside_menu"
    data-kt-scroll-offset="0"
>
    <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
        <div class="row">
            <div class="col d-flex justify-content-center">
                <p class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                    <span class="symbol-label font-size-h5 font-weight-bold">
                        {{ substr($currentAccount->name, 0, 1) }}
                    </span>
                </p>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col d-flex justify-content-center">
                <h5 class="text-white">{{  \Illuminate\Support\Str::words($currentAccount->name, 2, '...')   }} </h5>
            </div>
        </div>
        @if(Auth::user()->accounts()->count() > 1)
        <!--begin::Trigger-->
        <button type="button" class="btn btn-primary w-100"
                data-kt-menu-trigger="click"
                data-kt-menu-placement="bottom-start">
            {{ __('Switch Accounts') }}
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
                    @if (Illuminate\Support\Str::contains(Route::currentRouteName(), ['sites.show', 'sites.edit', 'groups.edit', 'contacts.edit', 'users.edit']))
                        <a href="{{ route('sites.index', $account->id) }}" class="menu-link px-3">
                            {{ $account->name }}
                        </a>
                    @elseif (Route::currentRouteName() === 'installs.show')
                        <!-- TODO: fix this -->
                    @else
                        <a href="{{ route(Route::currentRouteName(), $account->id) }}" class="menu-link px-3">
                            {{ $account->name }}
                        </a>
                    @endif
                </div>
                <!--end::Menu item-->

            @endforeach
        </div>
        @endif
    </div>

    {{--begin::Menu--}}
    <div
        class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500"
        id="#kt_aside_menu" data-kt-menu="true">
        @if(Gate::allows('isAdmin'))
        <div class="menu-item">
            <a class="menu-link" href="{{ route('admin.dashboard', $currentAccount->id) }}">
              <span class="menu-icon"><!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com006.svg-->
                  <span class="svg-icon svg-icon-2">
                    {!! get_svg_icon('skin/media/icons/duotune/abstract/abs046.svg') !!}
                  </span>
                  <!--end::Svg Icon-->
            </span>
                <span class="menu-title">{{ __('Accounts') }}</span>
            </a>
        </div>
        @endif
            <!-- Dashboard -->
            <div class="menu-item">
                <a class="menu-link" href="{{ route('dashboard', $currentAccount->id) }}">
                <span class="menu-icon">
                    <span class="svg-icon svg-icon-2">
                        {!! get_svg_icon('skin/media/icons/duotune/general/gen001.svg') !!}
                    </span>
                    <!--end::Svg Icon-->
                </span>
                    <span class="menu-title">{{ __('Dashboard') }}</span>
                </a>
            </div>
            @can('viewAny', \App\Models\Site::class)
            <!-- Sites -->
            <div class="menu-item">
                <a class="menu-link" href="{{ route('sites.index', $currentAccount->id) }}">
                    <span class="menu-icon">
                        <!--begin::Svg Icon | path: assets/media/icons/duotune/art/art003.svg-->
                        <span class="svg-icon svg-icon-2">
                            {!! get_svg_icon('skin/media/icons/duotune/abstract/abs027.svg') !!}
                        </span>
                        <!--end::Svg Icon-->
                    </span>
                    <span class="menu-title">{{ __('Sites') }}</span>
                </a>
            </div>
            @endcan
            @can('viewAny', \App\Models\User::class)
            <!-- Users -->
            <div data-kt-menu-trigger="click" class="menu-item menu-accordion"><span class="menu-link">
                <span class="menu-icon"><!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com006.svg-->
                    <span class="svg-icon svg-icon-2">
                        {!! get_svg_icon('skin/media/icons/duotune/communication/com014.svg') !!}
                    </span>
                <!--end::Svg Icon-->
                </span>
                <span class="menu-title">{{ __('Users') }}</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('users.index', $currentAccount->id) }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">{{ __('Account Users') }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('contacts.index', $currentAccount->id) }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">{{ __('Techincal Contacts') }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('logs.index', $currentAccount->id) }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">{{ __('Activity Log') }}</span>
                    </a>
                </div>
            </div>
        </div>
        @endcan
        @can('changeBilling', $currentAccount)
        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
            <span class="menu-link">
                <span class="menu-icon"><!--begin::Svg Icon | path: assets/media/icons/duotune/communication/com006.svg-->
                <span class="svg-icon svg-icon-2">
                    {!! get_svg_icon('skin/media/icons/duotune/finance/fin002.svg') !!}
                </span>
                        <!--end::Svg Icon-->
                </span>
                <span class="menu-title">{{ __('Billing') }}</span>
                <span class="menu-arrow"></span>
            </span>
            <div class="menu-sub menu-sub-accordion menu-active-bg">
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('billing.index', $currentAccount->id) }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">{{ __('Invoices') }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a class="menu-link" href="{{ route('billing.manageSubscriptions', $currentAccount->id) }}">
                        <span class="menu-bullet">
                            <span class="bullet bullet-dot"></span>
                        </span>
                        <span class="menu-title">{{ __('Modify Subscriptions') }}</span>
                    </a>
                </div>
            </div>
        </div>
        @endcan
    </div>
    {{--end::Menu--}}
</div>
{{--end::Aside Menu--}}
