<x-auth-layout>

    <!--begin::Signin Form-->
    <form method="POST" action="{{ route('login') }}" class="form w-100" novalidate="novalidate"
        id="kt_sign_in_form">
        @csrf

        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark mb-3">
                {{ __('Sign In To Steer Campaign') }}
            </h1>
            <!--end::Title-->

            <!--begin::Link-->
            <div class="text-gray-400 fw-bold fs-4">
                {{ __('New Here?') }}

                <a href="{{ route('register') }}" class="link-primary fw-bolder">
                    {{ __('Create an Account') }}
                </a>
            </div>
            <!--end::Link-->
        </div>
        <!--begin::Heading-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Label-->
            <label class="form-label fs-6 fw-bolder text-dark">{{ __('Email') }}</label>
            <!--end::Label-->

            <!--begin::Input-->
            <input tabindex="1" class="form-control form-control-lg form-control-solid @error('email') is-invalid @enderror" type="email" name="email" id="email" autocomplete="off"
                value="{{ old('email') }}" required autofocus />
            <!--end::Input-->
            @error('email')
                <span class="invalid-feedback" id="email-error">{{ $message }}</span>
            @enderror
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack mb-2">
                <!--begin::Label-->
                <label class="form-label fw-bolder text-dark fs-6 mb-0">{{ __('Password') }}</label>
                <!--end::Label-->

                <!--begin::Link-->
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="link-primary fs-6 fw-bolder">
                        {{ __('Forgot Password ?') }}
                    </a>
                @endif
                <!--end::Link-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Input-->
            <input tabindex="2" class="form-control form-control-lg form-control-solid" type="password" name="password"
                autocomplete="off" required />
            <!--end::Input-->
        </div>
        <!--end::Input group-->

        <!--begin::Input group-->
        <div class="fv-row mb-10">
            <label class="form-check form-check-custom form-check-solid">
                <input tabindex="3" class="form-check-input" type="checkbox" name="remember" />
                <span class="form-check-label fw-bold text-gray-700 fs-6">{{ __('Remember me') }}
                </span>
            </label>
        </div>
        <!--end::Input group-->

        <!--begin::Actions-->
        <div class="text-center">
            <!--begin::Submit button-->
            <button tabindex="4" type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                @include('partials.general._button-indicator', ['label' => __('Login')])
            </button>
            <!--end::Submit button-->
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Signin Form-->

    @push('scripts')
        <script src="skin/js/custom/authentication/sign-in/general.js"></script>
    @endpush
</x-auth-layout>
