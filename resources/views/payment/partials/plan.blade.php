@foreach($plans as $plan)
<!--begin::Col-->
<div class="col-xl-4">
    <div class="d-flex h-100 align-items-center">
        <!--begin::Option-->
        <div
            class="w-100 d-flex flex-column flex-center rounded-3 bg-light bg-opacity-75 py-15 px-10">
            <!--begin::Heading-->
            <div class="mb-7 text-center">
                <!--begin::Title-->
                <h1 class="text-dark mb-5 fw-boldest" id="plan-name">{{ $plan->display_name }}</h1>
                <!--end::Title-->
                <!--begin::Description-->
                <div class="text-gray-400 fw-bold mb-5">{{ $plan->description }}</div>
                <!--end::Description-->
                <!--begin::Price-->
                <div class="text-center">
                    <span class="mb-2 text-primary">$</span>
                    <span class="fs-3x fw-bolder text-primary" data-kt-element="price"
                        data-kt-plan-price-month="{{ $plan->monthly_price }}"
                        data-kt-plan-price-annual="{{ $plan->yearly_price }}">{{ $plan->monthly_price }}</span>
                    <span class="fs-7 fw-bold opacity-50">/
                        <span data-kt-element="period">{{ __('Mon') }}</span></span>
                </div>
                <!--end::Price-->
            </div>
            <!--end::Heading-->
            <!--begin::Features-->
            <div class="w-100">
                @foreach ($plan->features as $feature )
                <div class="d-flex align-items-center mb-5">
                    <span class="fw-bold fs-6 text-gray-800 flex-grow-1 pe-3">{{ $feature }}</span>
                    <span class="svg-icon svg-icon-1 svg-icon-success">
                        {!! get_svg_icon("icons/duotune/general/gen043.svg") !!}
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endforeach

