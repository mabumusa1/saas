<!--begin::Container-->
<div id="kt_content_container" class="container-xxl">
    @impersonating($guard = null)
    <div class="alert alert-danger">
        <p class="text-muted">{{ __('You are impersonating someone else')}}</p>
        <a class="btn btn-primary" href="{{ route('impersonate.leave') }}">{{ __('Leave impersonation') }} </a>
    </div>
    @endImpersonating
    
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    {{ $slot }}

</div>
<!--end::Container-->
