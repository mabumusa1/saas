@php
    $chartCcolor = $chartCcolor ?? 'primary';
    $chartHeight = $chartHeight ?? '175px';
@endphp

<!--begin::Mixed Widget 10-->
<div class="card {{ $class }}">
    <!--begin::Body-->
    <div class="card-body p-0 d-flex justify-content-between flex-column overflow-hidden">
        <div class="d-flex flex-stack flex-grow-1 px-9 pt-9 pb-3">
            <!--begin::Icon-->
            <div class="symbol symbol-45px">
                <div class="symbol-label">{!! theme()->getSvgIcon("icons/duotone/Shopping/Chart-line1.svg", "svg-icon-2x svg-icon-" . $chartCcolor) !!}</div>
            </div>
            <!--end::Icon-->

            <!--begin::Text-->
            <div class="d-flex flex-column text-end">
                <span class="fw-bolder text-gray-800 fs-3">Sales</span>
                <span class="text-gray-400 fw-bold">Oct 8 - Oct 26 <?php echo date("y")?></span>
            </div>
            <!--end::Text-->
        </div>

        <!--begin::Chart-->
        <div class="mixed-widget-10-chart" data-kt-color="{{ $chartCcolor }}" style="height: {{ $chartHeight }}"></div>
        <!--end::Chart-->
    </div>
</div>
<!--end::Mixed Widget 10-->
