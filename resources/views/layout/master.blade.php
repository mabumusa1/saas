@extends('base.base')

@section('content')

    <!--begin::Main-->
        <!--begin::Root-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="page d-flex flex-row flex-column-fluid">
                @include('layout/aside/_base')
                <!--begin::Wrapper-->
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    @include('layout/header/_base')
                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        @include('layout/toolbars/_toolbar-1')
                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            @include('layout/_content', compact('slot'))                            
                        </div>
                        <!--end::Post-->
                    </div>
                    <!--end::Content-->
                    @include('layout/_footer')                    
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Root-->

        @include('layout/_scrolltop')        
    <!--end::Main-->

@endsection
