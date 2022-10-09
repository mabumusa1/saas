<div class="card card-bordered mb-5">
    <div class="card-header bg-secondary">
        <h3 class="card-title">{{ __('2) How do you like to start?') }}</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <!--begin::Option-->
                <input type="radio" class="btn-check" name="start" value="blank" autocomplete="off" id="start_blank" checked/>
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="start_blank">
                <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-09-15-053640/core/html/src/media/icons/duotune/general/gen005.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M19 22H5C4.4 22 4 21.6 4 21V3C4 2.4 4.4 2 5 2H14L20 8V21C20 21.6 19.6 22 19 22ZM12.5 18C12.5 17.4 12.6 17.5 12 17.5H8.5C7.9 17.5 8 17.4 8 18C8 18.6 7.9 18.5 8.5 18.5L12 18C12.6 18 12.5 18.6 12.5 18ZM16.5 13C16.5 12.4 16.6 12.5 16 12.5H8.5C7.9 12.5 8 12.4 8 13C8 13.6 7.9 13.5 8.5 13.5H15.5C16.1 13.5 16.5 13.6 16.5 13ZM12.5 8C12.5 7.4 12.6 7.5 12 7.5H8C7.4 7.5 7.5 7.4 7.5 8C7.5 8.6 7.4 8.5 8 8.5H12C12.6 8.5 12.5 8.6 12.5 8Z" fill="currentColor"/>
                        <rect x="7" y="17" width="6" height="2" rx="1" fill="currentColor"/>
                        <rect x="7" y="12" width="10" height="2" rx="1" fill="currentColor"/>
                        <rect x="7" y="7" width="6" height="2" rx="1" fill="currentColor"/>
                        <path d="M15 8H20L14 2V7C14 7.6 14.4 8 15 8Z" fill="currentColor"/>
                        </svg>
                    </span>
                <!--end::Svg Icon-->            
    
                    <span class="d-block fw-semibold text-start">
                        <span class="text-dark fw-bold d-block fs-3">{{ __('Start with a blank site') }}</span>                
                        <span class="text-muted fw-semibold fs-6">
                            {{ __('Start with a fresh site') }}
                        </span>
        
                    </span>
                </label>
                <!--end::Option-->         
            </div>
            
            <div class="col-4">
                <!--begin::Option-->
                <input type="radio" class="btn-check" name="start" value="copyEnv" autocomplete="off" id="start_copy" disabled/>
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="start_copy">
                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-09-15-053640/core/html/src/media/icons/duotune/general/gen054.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.5" d="M18 2H9C7.34315 2 6 3.34315 6 5H8C8 4.44772 8.44772 4 9 4H18C18.5523 4 19 4.44772 19 5V16C19 16.5523 18.5523 17 18 17V19C19.6569 19 21 17.6569 21 16V5C21 3.34315 19.6569 2 18 2Z" fill="currentColor"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.7857 7.125H6.21429C5.62255 7.125 5.14286 7.6007 5.14286 8.1875V18.8125C5.14286 19.3993 5.62255 19.875 6.21429 19.875H14.7857C15.3774 19.875 15.8571 19.3993 15.8571 18.8125V8.1875C15.8571 7.6007 15.3774 7.125 14.7857 7.125ZM6.21429 5C4.43908 5 3 6.42709 3 8.1875V18.8125C3 20.5729 4.43909 22 6.21429 22H14.7857C16.5609 22 18 20.5729 18 18.8125V8.1875C18 6.42709 16.5609 5 14.7857 5H6.21429Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <span class="d-block fw-semibold text-start">
                        <span class="text-dark fw-bold d-block fs-3">{{ __('Copy a site') }}</span>
                        <span class="text-muted fw-semibold fs-6">
                            {{ __('Copy an existing install you have') }}
                        </span>
                        <span class="text-danger fw-semibold fs-6">
                            {{ __('Coming soon') }}
                        </span>
                    </span>
                </label>
                <!--end::Option-->         
            </div>
            <div class="col-4">
                <!--begin::Option-->
                <input type="radio" class="btn-check" name="start" value="moveEnv" autocomplete="off" id="start_move" disabled/>
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center" for="start_move">
                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-09-15-053640/core/html/src/media/icons/duotune/arrows/arr035.svg-->
                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M2 9.09998V3C2 2.4 2.4 2 3 2H9.10001L2 9.09998ZM22 9.09998V3C22 2.4 21.6 2 21 2H14.9L22 9.09998ZM2 14.9V21C2 21.6 2.4 22 3 22H9.10001L2 14.9ZM14.9 22H21C21.6 22 22 21.6 22 21V14.9L14.9 22Z" fill="currentColor"/>
                        <path d="M19.2 17.8L13.4 12L19.2 6.20001L17.8 4.79999L12 10.6L6.2 4.79999L4.8 6.20001L10.6 12L4.8 17.8L6.2 19.2L12 13.4L17.8 19.2L19.2 17.8Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <span class="d-block fw-semibold text-start">
                        <span class="text-dark fw-bold d-block fs-3">{{ __('Move to site') }}</span>
                        <span class="text-muted fw-semibold fs-6">
                            {{ __('Move an existing install') }}
                        </span>
                        <span class="d-block text-danger fw-semibold fs-6">
                            {{ __('Coming soon') }}
                        </span>
                    </span>
                </label>
                <!--end::Option-->                 
            </div>
            <div class="installs mt-4 col-12 d-none">
                <div class="mt-5">
                    <h5 class="text-dark">{{ __('Which install is the original install') }}</h5>
                    <select class="form-select" name="install_id" disabled>
                        <option value="" disabled selected>
                            {{ __('Please select an install') }}</option>
                        @foreach ($currentAccount->installs as $install)
                            <option value="{{ $install->id }}">{{ $install->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">
                        {{ __('Please select a valid Install.') }}
                    </div>
                </div>
            </div>            
        </div>        
    </div>
</div>