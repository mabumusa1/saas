<!--begin::Toolbar-->
<div class="toolbar" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="{{ theme()->printHtmlClasses('toolbar-container', false) }} d-flex flex-stack">
        @if (theme()->getOption('skin', 'page-title/display') && theme()->getOption('skin', 'header/left') !== 'page-title')
            {{ theme()->getView('skin/page-title/_default') }}
        @endif

		<!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Wrapper-->
            <div class="me-4">
                <!--begin::Menu-->
                <!--end::Menu-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Wrapper-->
            <!--end::Wrapper-->
        </div>
		<!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->
