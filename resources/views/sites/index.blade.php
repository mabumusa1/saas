<x-app-layout>
<<<<<<< HEAD
<div class="bg-white p-3">

    <!--begin::Wrapper-->
    <div class="d-flex flex-stack mb-5">
        <!--begin::Search-->
        <div class="d-flex align-items-center position-relative my-1">
            {!! theme()->getSvgIcon("icons/duotone/General/Search.svg", "svg-icon svg-icon-3 svg-icon-gray-500 position-absolute top-50 translate-middle ms-6") !!}
            <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Customers"/>
        </div>
        <!--end::Search-->

        <!--begin::Toolbar-->
        <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
            <!--begin::Filter-->
            <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="tooltip" title="Coming Soon">
                {!! theme()->getSvgIcon("icons/duotone/General/Filter.svg", "svg-icon svg-icon-3 svg-icon-gray-500") !!}
                Filter
            </button>
            <!--end::Filter-->

            <!--begin::Add customer-->
            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" title="Coming Soon">
                {!! theme()->getSvgIcon("icons/duotone/General/Plus.svg", "svg-icon svg-icon-3 svg-icon-gray-500") !!}
                Add Site
            </button>
            <!--end::Add customer-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Group actions-->
            <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                <div class="fw-bolder me-5">
                    <span class="me-2" data-kt-docs-table-select="selected_count"></span> Selected
                </div>

                <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" title="Coming Soon">
                    Selection Action
                </button>
            </div>
            <div id="sitesApp">
                <sites sites-route="{{route('sites.index')}}"></sites>
            </div>
        </div>
    </div>    
</x-app-layout>
=======
    <div id="sitesApp">
        <sites :sites='@json($sites)' :groups='@json($groups)' create-site-route="{{route('sites.create')}}"></sites>
    </div>
</x-app-layout>
>>>>>>> vuejs work
