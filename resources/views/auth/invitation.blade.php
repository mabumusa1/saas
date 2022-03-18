<x-auth-layout>

    <!--begin::Signup Form-->
    <form method="POST" action="{{ route('invites.accept') }}" class="form w-100" novalidate="novalidate">
        @csrf
        <input type="hidden" name="token" value="{{ $invite->token }}">
        <!--begin::Heading-->
        <div class="text-center mb-10">
            <!--begin::Title-->
            <h1 class="text-dark mb-3">
                {{ __("You've received an invitation") }}
            </h1>
            <!--end::Title-->

            <!--begin::Link-->
            <div class="fw-bold fs-4 mt-20">{{ __("You've been invitated as {$invite->role} to account {$invite->account->name}") }}</div>
            <!--end::Link-->
        </div>

        <!--begin::Actions-->
        <div class="text-center">
            <button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-primary">
                @include('partials.general._button-indicator', ['label' => __('Accept Invitation')])
            </button>
        </div>
        <!--end::Actions-->
    </form>
    <!--end::Signup Form-->
    @push('scripts')
        <script src="skin/js/custom/authentication/sign-up/general.js"></script>
    @endpush

</x-auth-layout>
