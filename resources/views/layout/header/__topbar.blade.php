@php
    $itemClass = "";
    $btnClass = "btn btn-icon btn-icon-muted btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px";
    $userAvatarClass = "";
    $btnIconClass = "svg-icon-1";
@endphp

<!--begin::Toolbar wrapper-->
<div class="d-flex align-items-stretch flex-shrink-0 float-right">
    <!--begin::Search-->
    <div class="d-flex align-items-stretch flex-shrink-0 float-right">
        @include('partials/search/_base')
    </div>
    <!--end::Search-->

    <!--begin::User menu-->
    <div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
        <!--begin::Menu wrapper-->
        <div class="cursor-pointer symbol symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                <span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1">{{ __('Hi,') }}</span>
                <span class="text-muted text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"> {{ auth()->user()->first_name }}</span>
                <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                    <span class="symbol-label font-size-h5 font-weight-bold">{{ substr(auth()->user()->first_name, 0, 1) }}</span>
                </span>
            </div>
        </div>
        @include('partials/topbar/_user-menu')
    <!--end::Menu wrapper-->
    </div>
    <!--end::User menu-->

    <!--begin::Header menu toggle-->
    <div class="d-flex align-items-center d-lg-none ms-2 me-n3" data-bs-toggle="tooltip" title="Show header menu">
        <div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
            {!! get_svg_icon("icons/duotune/text/txt001.svg", "svg-icon-1") !!}
        </div>
    </div>

<!--end::Header menu toggle-->
</div>
<!--end::Toolbar wrapper-->
