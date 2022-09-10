    @switch($install->status)
        @case('creating')
            <!--begin::Alert-->
            <div class="alert bg-info d-flex flex-column flex-sm-row p-5 mb-10">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                    {!! get_svg_icon('skin/media/icons/duotone/Code/Time-schedule.svg', 'svg-icon-2x') !!}
                </span>
                <!--end::Icon-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                    <!--begin::Content-->
                    <span>{{ __('Your installation is being created, we will notify you when it is ready') }}</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->        
            @break
            
            @break
        @case('up')
            <!--begin::Alert-->
            <div class="alert bg-success d-flex flex-column flex-sm-row p-5 mb-10">
                <!--begin::Icon-->
                <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                    {!! get_svg_icon('skin/media/icons/duotone/Code/Done-circle.svg', 'svg-icon-2x') !!}
                </span>
                <!--end::Icon-->
                <!--begin::Wrapper-->
                <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                    <!--begin::Content-->
                    <span>{{ __('Your installation is running normally') }}</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->        
            @break
        @case('down')
            <!--begin::Alert-->
            <div class="alert bg-danger d-flex flex-column flex-sm-row p-5 mb-10">

            <!--begin::Icon-->
            <span class="svg-icon svg-icon-2hx svg-icon-light me-4 mb-5 mb-sm-0">
                {!! get_svg_icon('skin/media/icons/duotone/Code/Error-circle.svg', 'svg-icon-2x') !!}
            </span>
            <!--end::Icon-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-column text-light pe-0 pe-sm-10">
                <!--begin::Content-->
                <span>{{ __('Your installation is down, please contact support') }}</span>
                <!--end::Content-->
            </div>
            <!--end::Wrapper-->
            @break
            <!--end::Alert-->            
    @endswitch
</div>


