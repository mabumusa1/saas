{{--begin::Aside--}}
<div
    id="kt_aside"
    class="aside aside-dark"
    data-kt-drawer="true"
    data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}"
    data-kt-drawer-overlay="true"
    data-kt-drawer-width="{default:'200px', '300px': '250px'}"
    data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle"
>

    {{--begin::Brand--}}
    <div class="aside-logo flex-column-auto" id="kt_aside_logo">
        {{--begin::Logo--}}
        <a href="{{ route('sites.index', $currentAccount->id) }}">
            <img alt="Logo" src="{{ asset('skin/media/logos/logo-dark.svg') }}" class="h-50px logo"/>
        </a>
        {{--end::Logo--}}
    </div>
    {{--end::Brand--}}

    {{--begin::Aside menu--}}
    <div class="aside-menu flex-column-fluid">
        @include('layout/aside/_menu')
    </div>
    {{--end::Aside menu--}}

    {{--begin::Footer--}}
    <div class="aside-footer flex-column-auto pt-5 pb-7 px-5" id="kt_aside_footer">
    </div>
    {{--end::Footer--}}
</div>
{{--end::Aside--}}
