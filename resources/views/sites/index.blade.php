<x-app-layout>
<div class="bg-white p-3">

    <!--begin::Wrapper-->
    <div class="d-flex flex-stack mb-5">
        <!--begin::Search-->
        <div id="sites-search-bar" class="d-flex align-items-center position-relative my-1">
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
            <!--end::Group actions-->
        </div>
        <!--end::Wrapper-->

        <!--begin::Table-->
        {{ $dataTable->table(['class' => 'table table-striped table-row-dashed table-row-gray-300 gy-7']) }}
        <!--end::Table-->

        {{-- Inject Scripts --}}
        @push('scripts')
            {{ $dataTable->scripts() }}
            <script src="https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.7.7/handlebars.min.js" integrity="sha512-RNLkV3d+aLtfcpEyFG8jRbnWHxUqVZozacROI4J2F1sTaDqo1dPQYs01OMi1t1w9Y2FdbSCDSQ2ZVdAC8bzgAg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

            <script id="details-template" type="text/x-handlebars-template">
                    <tr>
                        <td>
                            <p>
                                
                                <div class="row">
                                    <div class="col">
                                        <span class="badge badge-@{{badgeClass}}">@{{type}}</span>
                                    </div>
                                    <div class="col">
                                        <span>@{{name}}</span><br/>
                                        <span>site.steercampaign.com</span>
                                    </div>
                                </div>
                            </p>
                        </td>
                        <td></td>
                        <td>@{{php}}</td>
                        <td>@{{bandwidth}}</td>
                        <td>@{{storage}}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group" aria-label="actions">
                                <a href="backup/@{{id}}" class="btn btn-light btn-sm">{{__('Backup')}}</a>
                                <a href="cache/@{{id}}" class="btn btn-light btn-sm">{{__('Purge Cache')}}</a>
                                <a href="delete/@{{id}}" class="btn btn-danger btn-sm">{{__('Delete')}}</a>
                            </div>
                        </td>
                    </tr>
            </script>            
        @endpush
</div>
</x-app-layout>