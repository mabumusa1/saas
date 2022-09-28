<div class="card card-bordered mb-5">
    <div class="card-header bg-secondary">
        <h3 class="card-title">{{ __('3) Configure your install') }}</h3>
    </div>
    <div class="card-body">
        {{-- Add Subscription --}}
        <div class="row">
            <div class="col-6">
                <!--begin::Input group-->
                <div class="mb-10">
                    <label for="siteName">{{ __('Site Name') }}</label>
                    <input type="text" name="sitename" id="siteName" class="form-control fv-row" placeholder="{{ __('Site Name') }}"/>
                </div>
                <!--end::Input group-->
            </div>
            <div class="col-6">
                <div id="siteNameHelpBlock" class="form-text" >
                    {{ __('Site name is a container for two installs, one used in production and another is used as a sandbox') }}
                </div>                    
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <!--begin::Input group-->
                <div class="mb-10">
                    <div class="input-group">
                        <input type="text" name="installname" id="installName" class="w-50 form-control" placeholder="{{ __('Install Name') }}" aria-label="{{ __('Install Name') }}" aria-describedby="installNameLabel"/>
                        <span class="input-group-text" id="installNameLabel">.{{env('CNAME_DOMAIN')}}
                            <div class="m-1 spinner-border" role="status" id="progressBar" style="opacity: 0;">
                                <span class="sr-only">{{ __('Loading...') }}</span>
                              </div>                        
    
                        </span>
                    </div>
                </div>
                <!--end::Input group-->                
            </div>
            <div class="col-6">
                <div id="installNameeHelpBlock" class="form-text">
                    {{ __('Install Name is the internal name we use to setup your installation, you can add your domain later once the instllation is over') }}
                </div>                    
            </div>
        </div>
        {{ dd($currentAccount->availableSubscriptions) }}
        @if ($currentAccount->availableSubscriptionsCount > 0)
        <div class="row">
            <div class="col-6">
                <label>{{ __('Subscription Type') }}</label>
                <select name="subscription_id" id="subscription_id"
                    class="form-control form-control-solid">
                    @foreach ($currentAccount->availableSubscriptions as $subscription)
                        <option value="{{ $subscription->id }}"
                            @if ($subscription->id == $currentAccount->subscription_id) selected @endif>
                            {{ $subscription->displayName }}
                            @if ($subscription->quantity - $subscription->sites_count > 0)
                                ({{ $subscription->quantity - $subscription->sites_count }}
                                sites available)
                            @endif
                        </option>
                    @endforeach
                </select>                
            </div>
            <div class="col-6">
                <div id="installNameeHelpBlock" class="form-text">
                    {{ __('Select the subscription that you want to use, this will control the size of your install') }}
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-6">
                <!--begin::Option-->
                <input type="radio" class="btn-check" name="type" value="prd" id="radioPrd" autocomplete="off" @if(!$canCreateMine) disabled @endif @if($canCreateMineChecked) checked @endif>
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="radioPrd">
                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-09-15-053640/core/html/src/media/icons/duotune/general/gen002.svg-->
                    <span class="svg-icon svg-icon-4x me-4"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path opacity="0.3" d="M4.05424 15.1982C8.34524 7.76818 13.5782 3.26318 20.9282 2.01418C21.0729 1.98837 21.2216 1.99789 21.3618 2.04193C21.502 2.08597 21.6294 2.16323 21.7333 2.26712C21.8372 2.37101 21.9144 2.49846 21.9585 2.63863C22.0025 2.7788 22.012 2.92754 21.9862 3.07218C20.7372 10.4222 16.2322 15.6552 8.80224 19.9462L4.05424 15.1982ZM3.81924 17.3372L2.63324 20.4482C2.58427 20.5765 2.5735 20.7163 2.6022 20.8507C2.63091 20.9851 2.69788 21.1082 2.79503 21.2054C2.89218 21.3025 3.01536 21.3695 3.14972 21.3982C3.28408 21.4269 3.42387 21.4161 3.55224 21.3672L6.66524 20.1802L3.81924 17.3372ZM16.5002 5.99818C16.2036 5.99818 15.9136 6.08615 15.6669 6.25097C15.4202 6.41579 15.228 6.65006 15.1144 6.92415C15.0009 7.19824 14.9712 7.49984 15.0291 7.79081C15.0869 8.08178 15.2298 8.34906 15.4396 8.55884C15.6494 8.76862 15.9166 8.91148 16.2076 8.96935C16.4986 9.02723 16.8002 8.99753 17.0743 8.884C17.3484 8.77046 17.5826 8.5782 17.7474 8.33153C17.9123 8.08486 18.0002 7.79485 18.0002 7.49818C18.0002 7.10035 17.8422 6.71882 17.5609 6.43752C17.2796 6.15621 16.8981 5.99818 16.5002 5.99818Z" fill="currentColor"/>
                        <path d="M4.05423 15.1982L2.24723 13.3912C2.15505 13.299 2.08547 13.1867 2.04395 13.0632C2.00243 12.9396 1.9901 12.8081 2.00793 12.679C2.02575 12.5498 2.07325 12.4266 2.14669 12.3189C2.22013 12.2112 2.31752 12.1219 2.43123 12.0582L9.15323 8.28918C7.17353 10.3717 5.4607 12.6926 4.05423 15.1982ZM8.80023 19.9442L10.6072 21.7512C10.6994 21.8434 10.8117 21.9129 10.9352 21.9545C11.0588 21.996 11.1903 22.0083 11.3195 21.9905C11.4486 21.9727 11.5718 21.9252 11.6795 21.8517C11.7872 21.7783 11.8765 21.6809 11.9402 21.5672L15.7092 14.8442C13.6269 16.8245 11.3061 18.5377 8.80023 19.9442ZM7.04023 18.1832L12.5832 12.6402C12.7381 12.4759 12.8228 12.2577 12.8195 12.032C12.8161 11.8063 12.725 11.5907 12.5653 11.4311C12.4057 11.2714 12.1901 11.1803 11.9644 11.1769C11.7387 11.1736 11.5205 11.2583 11.3562 11.4132L5.81323 16.9562L7.04023 18.1832Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <span class="d-block fw-semibold text-start">
                        <span class="text-dark fw-bold d-block fs-3">{{ __('Production') }}</span>
                        <span class="text-muted fw-semibold fs-6">
                            {{ __('This install will be used in production, it will be accessible from the internet and active') }}
                        </span>
                    </span>
                </label>
                <!--end::Option-->
            </div>
            <div class="col-6">
                <!--begin::Option-->
                <input type="radio" class="btn-check"  name="type" value="dev" id="radioDev" autocomplete="off" @if(!$canCreateMine && $canCreateTransferable)checked @endif>
                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5" for="radioDev">
                    <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-09-15-053640/core/html/src/media/icons/duotune/general/gen047.svg-->
                    <span class="svg-icon svg-icon-4x me-4"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                        <path d="M15.8054 11.639C15.6757 11.5093 15.5184 11.4445 15.3331 11.4445H15.111V10.1111C15.111 9.25927 14.8055 8.52784 14.1944 7.91672C13.5833 7.30557 12.8519 7 12 7C11.148 7 10.4165 7.30557 9.80547 7.9167C9.19432 8.52784 8.88885 9.25924 8.88885 10.1111V11.4445H8.66665C8.48153 11.4445 8.32408 11.5093 8.19444 11.639C8.0648 11.7685 8 11.926 8 12.1112V16.1113C8 16.2964 8.06482 16.4539 8.19444 16.5835C8.32408 16.7131 8.48153 16.7779 8.66665 16.7779H15.3333C15.5185 16.7779 15.6759 16.7131 15.8056 16.5835C15.9351 16.4539 16 16.2964 16 16.1113V12.1112C16.0001 11.926 15.9351 11.7686 15.8054 11.639ZM13.7777 11.4445H10.2222V10.1111C10.2222 9.6204 10.3958 9.20138 10.7431 8.85421C11.0903 8.507 11.5093 8.33343 12 8.33343C12.4909 8.33343 12.9097 8.50697 13.257 8.85421C13.6041 9.20135 13.7777 9.6204 13.7777 10.1111V11.4445Z" fill="currentColor"/>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->                    
                    <span class="d-block fw-semibold text-start">
                        <span class="text-dark fw-bold d-block fs-3">{{ __('Sandbox') }}</span>
                        <span class="text-muted fw-semibold fs-6">
                            {{ __('This install will be used for testing, it will be protected by username and password') }}
                        </span>
                    </span>
                </label>
                <!--end::Option-->

            </div>
        </div>
    </div>
</div>

