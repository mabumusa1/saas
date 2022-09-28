<div class="card card-bordered mb-5">
    <div class="card-header bg-secondary">
        <h3 class="card-title">{{ __('1) Who owns the site?') }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <!--begin::Option-->
                <input type="radio" class="btn-check" name="owner" value="mine" id="radioMine" autocomplete="off" @if($canCreateMine) checked @else disabled @endif>
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="radioMine">
                    <!--begin::Svg Icon | path: icons/duotune/coding/cod001.svg-->
                    <span class="svg-icon svg-icon-4x me-4">
                            <!--begin::Svg Icon | path: skin/media/icons/duotune/communication/com013.svg-->
                            <span class="svg-icon svg-icon-muted svg-icon-3hx svg-icon-primary"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.28548 15.0861C7.34369 13.1814 9.35142 12 11.5304 12H12.4696C14.6486 12 16.6563 13.1814 17.7145 15.0861L19.3493 18.0287C20.0899 19.3618 19.1259 21 17.601 21H6.39903C4.87406 21 3.91012 19.3618 4.65071 18.0287L6.28548 15.0861Z" fill="currentColor"/>
                                <rect opacity="0.3" x="8" y="3" width="8" height="8" rx="4" fill="currentColor"/>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->                                
                    </span>
                    <!--end::Svg Icon-->
                    <span class="d-block fw-semibold text-start">
                        <span class="text-dark fw-bold d-block fs-3">{{ __('I will use this site') }}</span>
                        <span class="text-muted fw-semibold fs-6">
                            {{ __('This site will be used in production and I will run it and pay for it') }}
                        </span>
                        <span class="d-block fw-semibold text-start mt-3">
                            <span class="fw-semibold fs-6">
                                {{ __('You have :available subscription to be used', ['available' => $currentAccount->availableSubscriptionsCount]) }}
                            </span>
                        </span>    
                    </span>
                </label>
                <!--end::Option-->
            </div>
            <div class="col-6">
                <!--begin::Option-->
                <input type="radio" class="btn-check" name="owner" value="transferable" autocomplete="off" id="radioTransferable" @if(!$canCreateTransferable) disabled @endif @if($canCreateTransferableChecked) checked @endif  /> 
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="radioTransferable">
                    <!--begin::Svg Icon | path: icons/duotune/communication/com003.svg-->
                    <span class="svg-icon svg-icon-4x me-4">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-09-15-053640/core/html/src/media/icons/duotune/general/gen016.svg-->
                        <span class="svg-icon svg-icon-muted svg-icon-3hx svg-icon-primary">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15.43 8.56949L10.744 15.1395C10.6422 15.282 10.5804 15.4492 10.5651 15.6236C10.5498 15.7981 10.5815 15.9734 10.657 16.1315L13.194 21.4425C13.2737 21.6097 13.3991 21.751 13.5557 21.8499C13.7123 21.9488 13.8938 22.0014 14.079 22.0015H14.117C14.3087 21.9941 14.4941 21.9307 14.6502 21.8191C14.8062 21.7075 14.9261 21.5526 14.995 21.3735L21.933 3.33649C22.0011 3.15918 22.0164 2.96594 21.977 2.78013C21.9376 2.59432 21.8452 2.4239 21.711 2.28949L15.43 8.56949Z" fill="currentColor"/>
                            <path opacity="0.3" d="M20.664 2.06648L2.62602 9.00148C2.44768 9.07085 2.29348 9.19082 2.1824 9.34663C2.07131 9.50244 2.00818 9.68731 2.00074 9.87853C1.99331 10.0697 2.04189 10.259 2.14054 10.4229C2.23919 10.5869 2.38359 10.7185 2.55601 10.8015L7.86601 13.3365C8.02383 13.4126 8.19925 13.4448 8.37382 13.4297C8.54839 13.4145 8.71565 13.3526 8.85801 13.2505L15.43 8.56548L21.711 2.28448C21.5762 2.15096 21.4055 2.05932 21.2198 2.02064C21.034 1.98196 20.8409 1.99788 20.664 2.06648Z" fill="currentColor"/>
                        </svg>
                        <!--end::Svg Icon-->
                        </span>
                    </span>
                    <!--end::Svg Icon-->
        
                    <span class="d-block fw-semibold text-start">
                        <span class="text-dark fw-bold d-block fs-3">{{ __('This site is transferable') }}</span>
                        <span class="text-muted fw-semibold fs-6">{{ __('I am building it for someone else, it will be moved their account, and they will pay for it ') }}</span>
                        <span class="d-block fw-semibold text-start mt-3">
                            <span class="fw-semibold fs-6">
                                {{ __('You have :available transferable site to be used', ['available' => $currentAccount->availableQuota]) }}
                            </span>
                        </span>

                    </span>
                    
                </label>
                <!--end::Option-->            
            </div>
        </div>
    </div>
</div>