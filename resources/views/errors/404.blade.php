@extends('base.base')
@section('content')
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - 404 Page-->
        <div class="d-flex flex-column flex-center flex-column-fluid p-10">
            <!--begin::Illustration-->
            <img src="{{ asset(theme()->getMediaUrlPath() . 'illustrations/sketchy-1/18.png') }}" alt=""
                class="mw-100 mb-10 h-lg-450px">
            <!--end::Illustration-->
            <!--begin::Message-->
            <h1 class="fw-bold mb-10" style="color: #A3A3C7">{{ __('Seems there is nothing here') }}</h1>
            <!--end::Message-->
        </div>
        <!--end::Authentication - 404 Page-->
    </div>
@endsection
