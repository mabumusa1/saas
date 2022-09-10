<div class="alert alert-dismissible alert-primary d-flex align-items-center p-5 mb-10">
    <!--begin::Icon-->
    <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
        {!! get_svg_icon('skin/media/icons/duotune/general/gen002.svg') !!}
    </span>
    <!--end::Icon-->
    <!--begin::Wrapper-->
    <div class="d-flex flex-column">
        <!--begin::Title-->
        <h4 class="mb-2 dark">{{ __('Go live checklist') }}</h4>
        <!--end::Title-->
        <div class="d-flex">
            <!--begin::Content-->
            <span>{{ __('It is easy to lose track of all the required and optimal task for a site launcher. Use our checklist for keeping track. Find it any time in your site details links on the left.') }}</span>
            <!--end::Content-->
            <div class="flex-lg-row-auto ms-4">
                <a href="{{ route('installs.liveCheck', ['account' => $currentAccount, 'install' => $install, 'site' => $site]) }}"
                    class="btn btn-primary">{{ __('See the checklist') }}</a>
            </div>
        </div>
        <!--end::Wrapper-->
        <!--begin::Close-->
        <button type="button"
            class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
            data-bs-dismiss="alert">
            <i class="bi bi-x fs-1 text-primary"></i>
        </button>
        <!--end::Close-->
    </div>

</div>
