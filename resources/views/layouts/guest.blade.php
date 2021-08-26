@extends('layouts.base')

@section('content')
    <!--begin::Authentication-->
    <div
        class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed"
        style="background-image: url({{ secure_asset(theme()->getMediaUrlPath() . 'illustrations/progress-hd.png') }})">

        <!--begin::Content-->
        <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
            <!--begin::Logo-->
            <a href="{{ $theme->getPageUrl('dashboard') }}" class="mb-12">
                <img alt="Logo" src="{{ secure_asset(theme()->getMediaUrlPath() . 'logos/logo-dark.svg') }}" class="h-45px"/>
            </a>
            <!--end::Logo-->

            <!--begin::Wrapper-->
            <div class="w-lg-500px bg-white rounded shadow-sm p-10 p-lg-15 mx-auto">
                {{ $slot }}
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Content-->

        <!--begin::Footer-->
        <div class="d-flex flex-center flex-column-auto p-10">
            <!--begin::Links-->
            <div class="d-flex align-items-center fw-bold fs-6">
            </div>
            <!--end::Links-->
        </div>
        <!--end::Footer-->
    </div>
    <!--end::Authentication-->
@endsection