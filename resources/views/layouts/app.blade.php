@extends('layouts.base')

@section('content')

    <!--begin::Main-->
    @if (theme()->getOption('skin', 'main/type') === 'blank')
        <div class="d-flex flex-column flex-root">
            {{ $slot }}
        </div>
    @else
        <!--begin::Root-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="page d-flex flex-row flex-column-fluid">
            @if( theme()->getOption('skin', 'aside/display') === true )
                {{ theme()->getView('skin/aside/_base') }}
            @endif

                <!--begin::Wrapper-->
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                {{ theme()->getView('skin/header/_base') }}

                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid {{ theme()->printHtmlClasses('content', false) }}" id="kt_content">
                    @if (theme()->getOption('skin', 'toolbar/display') === true)
                        {{ theme()->getView('skin/toolbars/_' . theme()->getOption('skin', 'toolbar/layout')) }}
                    @endif

                        <!--begin::Post-->
                        <div class="post d-flex flex-column-fluid" id="kt_post">
                            {{ theme()->getView('skin/_content', compact('slot')) }}
                        </div>
                        <!--end::Post-->
                    </div>
                    <!--end::Content-->

                    {{ theme()->getView('skin/_footer') }}
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Page-->
        </div>
        <!--end::Root-->

        @if(theme()->getOption('skin', 'scrolltop/display') === true)
            {{ theme()->getView('skin/_scrolltop') }}
        @endif
    @endif
    <!--end::Main-->

@endsection