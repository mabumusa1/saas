<!--begin::Header-->
<div id="kt_header" style="" class="header align-items-stretch">
	<!--begin::Container-->
	<div class="container-fluid d-flex align-items-stretch justify-content-between">
		<!--begin::Aside mobile toggle-->
			<div class="d-flex align-items-center d-lg-none ms-n3 me-1" data-bs-toggle="tooltip" title="Show aside menu">
				<div class="btn btn-icon btn-active-light-primary" id="kt_aside_mobile_toggle">
					{!! get_svg_icon("icons/duotune/abstract/abs015.svg", "svg-icon-2x mt-1") !!}
				</div>
			</div>
		<!--end::Aside mobile toggle-->
			<!--begin::Mobile logo-->
			<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
				<a href="{{ route('sites.index', $currentAccount->id) }}" class="d-lg-none">
					<img alt="Logo" src="{{ asset('skin/media/logos/logo-1.svg') }}" class="h-15px"/>
				</a>
			</div>
			<!--end::Mobile logo-->
		<!--begin::Wrapper-->
		<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
			<!--begin::Topbar-->
			<div class="d-flex align-items-stretch" id="kt_header_nav">
			</div>
	        <div class="d-flex align-items-stretch flex-shrink-0 top-bar ">
				@include('layout/header/__topbar')                
			</div>
			<!--end::Topbar-->
		</div>
		<!--end::Wrapper-->
	</div>
	<!--end::Container-->
</div>
<!--end::Header-->
