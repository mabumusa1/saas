<!--begin::Search-->
<div id="kt_header_search" class="d-flex align-items-stretch" data-kt-search-keypress="true"
    data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-menu-trigger="auto"
    data-kt-menu-overflow="false" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-end">

    <!--begin::Search toggle-->
    <div class="d-flex align-items-center" data-kt-search-element="toggle" id="kt_header_search_toggle">
        <div class="btn btn-icon btn-active-light-primary btn-custom">
            {!! theme()->getSvgIcon('icons/duotune/general/gen021.svg', 'svg-icon-1') !!}
        </div>
    </div>
    <!--end::Search toggle-->

    <!--begin::Menu-->
    <div data-kt-search-element="content" class="menu menu-sub menu-sub-dropdown p-7 w-325px w-md-375px">
        <!--begin::Wrapper-->
        <div data-kt-search-element="wrapper">
            {{ theme()->getView('partials/search/partials/_form') }}
            <div class="separator border-gray-200 mb-6"></div>
            <div data-kt-search-element="results" class="d-none">
                ...
            </div>
            <div data-kt-search-element="main">

            </div>
            <div data-kt-search-element="empty" class="text-center d-none">
                <!--begin::Icon-->
                <div class="pt-10 pb-10">
                    <!--begin::Svg Icon | path: icons/duotune/files/fil024.svg-->
                    <span class="svg-icon svg-icon-4x opacity-50">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" fill="black"></path>
                            <path d="M20 8L14 2V6C14 7.10457 14.8954 8 16 8H20Z" fill="black"></path>
                            <rect x="13.6993" y="13.6656" width="4.42828" height="1.73089" rx="0.865447" transform="rotate(45 13.6993 13.6656)" fill="black"></rect>
                            <path d="M15 12C15 14.2 13.2 16 11 16C8.8 16 7 14.2 7 12C7 9.8 8.8 8 11 8C13.2 8 15 9.8 15 12ZM11 9.6C9.68 9.6 8.6 10.68 8.6 12C8.6 13.32 9.68 14.4 11 14.4C12.32 14.4 13.4 13.32 13.4 12C13.4 10.68 12.32 9.6 11 9.6Z" fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                </div>
                <!--end::Icon-->
                <!--begin::Message-->
                <div class="pb-15 fw-bold">
                    <h3 class="text-gray-600 fs-5 mb-2">No result found</h3>
                    <div class="text-muted fs-7">Please try again with a different query</div>
                </div>
                <!--end::Message-->
            </div>
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Menu-->
</div>
<!--end::Search-->
