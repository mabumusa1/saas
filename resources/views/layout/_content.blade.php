<!--begin::Container-->
<div id="kt_content_container" class="{{ theme()->printHtmlClasses('content-container', false) }}">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    {{ $slot }}
</div>
<!--end::Container-->
