        <!--begin::Toolbar-->
        <div class="toolbar" id="kt_toolbar">
            <!--begin::Container-->
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack h-100">
                <div
                    class="align-items-center border border-bottom-0 border-left-0 border-right-2 border-top-0 col-3 d-flex h-100 justify-content-between">
                    <span class="text-black">{{ $install->name }}</span>
                    <span class="svg-icon svg-icon-5 ms-1 me-2 svg-icon-md-1">{!! get_svg_icon('skin/media/icons/duotone/General/Other2.svg') !!}</span>
                </div>
                <div class="col col-3 border border-bottom-0 border-left-0 border-right-2 border-top-0 h-100 d-flex">
                    <!--begin::Trigger-->
                    <button type="button" class="btn ps-3 pe-3" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-start">
                        <span class="badge badge-info me-2">{{ strtoupper($install->type) }}</span>
                        {{ $install->name }}
                        <span class="svg-icon svg-icon-5 ms-1 me-0 svg-icon-md-1">{!! get_svg_icon('skin/media/icons/duotone/Navigation/Angle-down.svg') !!}</span>
                    </button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-225px"
                        data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item bg-dark text-light">
                            <a class="menu-link px-3 d-flex justify-content-between disabled">
                                <div>
                                    <span class="badge badge-info me-3">{{ strtoupper($install->type) }}</span>
                                    {{ $install->name }}
                                </div>
                                <span
                                    class="svg-icon svg-icon-5 ms-3 me-0 svg-icon-md-1 svg-icon-light">{!! get_svg_icon('skin/media/icons/duotune/arrows/arr085.svg') !!}</span>
                            </a>
                        </div>
                        @if($site->hasInstallType('prd') )
                        @if($install->type !== 'prd')
                        <?php
                            $prdInstall = $site->installs->where('type', 'prd')->first();
                        ?>
                        <div class="menu-item">
                            <a href="{{ route('installs.show', ['account' => $account, 'site' => $site, 'install' => $prdInstall->id]) }}" class="menu-link px-3 d-flex justify-content-between">
                                <div>
                                    <span class="badge badge-primary me-3">{{ __('PRD') }}</span>
                                    {{ $prdInstall->name }}
                                </div>
                            </a>
                        </div>
                        @endif
                        @else
                        <div class="menu-item bg-light-primary text-light">
                            <a class="menu-link px-3 d-flex justify-content-between disabled" href="{{ route('installs.create', ['account' => $currentAccount, 'site' => $site]) }}?env=prd">{{ __('Add Production install') }}</a>
                        </div>
                        @endif
 
                        @if($site->hasInstallType('dev'))
                        <div class="menu-item bg-light-primary text-light">
                            <a class="menu-link px-3 d-flex justify-content-between disabled" {{-- href="{{ route('installs.create', ['account' => $currentAccount, 'site' => $site]) }}?env=dev" --}}>{{ __('Add Development install') }}</a>
                        </div>
                        @endif
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <div class="col d-flex justify-content-between align-items-center ms-3">
                    <div class="d-inline-flex">
                        <a href="https://{{ $install->name }}.{{env('CNAME_DOMAIN')}}" class="me-4">{{ __('Mautic Login') }}<span
                                class="svg-icon svg-icon-5 me-0 svg-icon-md-1">{!! get_svg_icon('skin/media/icons/duotune/arrows/arr095.svg') !!}</span></a>
                    </div>
                    <button @if($site->installs()->count() < 2) disabled @else data-bs-toggle="modal" data-bs-target="#copy_install_modal" @endif class="btn border border-2 border-primary text-primary">{{ __('Copy install') }}</button>
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::Toolbar-->
