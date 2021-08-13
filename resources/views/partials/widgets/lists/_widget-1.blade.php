<?php
    // List items
    $listRows = array(
        array(
            'icon' => 'icons/duotone/Home/Library.svg',
            'color' => 'success',
            'title' => 'Project Briefing',
            'description' => 'Project Manager',
        ),
        array(
            'icon' => 'icons/duotone/Communication/Write.svg',
            'color' => 'warning',
            'title' => 'Concept Design',
            'description' => 'Art Director'
        ),
        array(
            'icon' => 'icons/duotone/Communication/Group-chat.svg',
            'color' => 'primary',
            'title' => 'Functional Logics',
            'description' => 'Lead Developer'
        ),
        array(
            'icon' => 'icons/duotone/General/Attachment2.svg',
            'color' => 'danger',
            'title' => 'Development',
            'description' => 'DevOps'
        ),
        array(
            'icon' => 'icons/duotone/Communication/Shield-user.svg',
            'color' => 'info',
            'title' => 'Testing',
            'description' => 'QA Managers'
        )
    );
?>


<!--begin::List Widget 1-->
<div class="card {{ $class }}">
    <!--begin::Header-->
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
			<span class="card-label fw-bolder text-dark">Tasks Overview</span>
			<span class="text-muted mt-1 fw-bold fs-7">Pending 10 tasks</span>
		</h3>

        <div class="card-toolbar">
            <!--begin::Menu-->
            <button type="button" class="btn btn-sm btn-icon btn-color-primary btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                {!! theme()->getSvgIcon("icons/duotone/Layout/Layout-4-blocks-2.svg", "svg-icon-2") !!}
            </button>
            {{ theme()->getView('partials/menus/_menu-1') }}
            <!--end::Menu-->
        </div>
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body pt-5">
        @foreach($listRows as $row)
            <!--begin::Item-->
            <div class="d-flex align-items-center {{ util()->putIf(next($listRows), 'mb-7') }}">
                <!--begin::Symbol-->
                <div class="symbol symbol-50px me-5">
                    <span class="symbol-label bg-light-{{ $row['color'] }}">
                        {!! theme()->getSvgIcon($row['icon'], "svg-icon-2x svg-icon-" . $row['color']); !!}
                    </span>
                </div>
                <!--end::Symbol-->

                <!--begin::Text-->
                <div class="d-flex flex-column">
                    <a href="#" class="text-dark text-hover-primary fs-6 fw-bolder">{{ $row['title'] }}</a>

                    <span class="text-muted fw-bold">{{ $row['description'] }}</span>
                </div>
                <!--end::Text-->
            </div>
            <!--end::Item-->
        @endforeach
    </div>
    <!--end::Body-->
</div>
<!--end::List Widget 1-->
