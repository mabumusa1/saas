<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
{{-- begin::Head --}}
<head>
    <meta charset="utf-8"/>
    <title>Steer Campaign</title>
    <meta name="description" content="Steer Campaign the marketing automation solution based on Mautic"/>
    <meta name="keywords" content="marketing automation, mautic, white-label"/>
    <link rel="canonical" href="{{ url()->current() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="skin/media/logos/favicon.ico"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- begin::Fonts --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>
    {{-- end::Fonts --}}
    
    <link rel="preload" href="{{ asset('skin/plugins/global/plugins.bundle.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'" type="text/css"><noscript><link rel="stylesheet" href="https://sc.ddev.site/skin/plugins/global/plugins.bundle.css"></noscript>
    <link rel="preload" href="{{ asset('skin/plugins/global/plugins-custom.bundle.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'" type="text/css"><noscript><link rel="stylesheet" href="https://sc.ddev.site/skin/plugins/global/plugins-custom.bundle.css"></noscript>
    <link href="{{ asset('skin/css/style.bundle.css') }}" rel="stylesheet" type="text/css"/>

    @stack('styles')
</head>
{{-- end::Head --}}

{{-- begin::Body --}}
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed"   style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">

@yield('content')

<script src="{{ asset('skin/plugins/global/plugins.bundle.js') }}" type="application/javascript"></script>
<script src="{{ asset('skin/js/scripts.bundle.js') }}" type="application/javascript"></script>
<script src="{{ asset('skin/js/custom/widgets.js') }}" type="application/javascript"></script>

{{-- end::Javascript --}}

@stack('scripts')

</body>
{{-- end::Body --}}
</html>
