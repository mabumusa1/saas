<div class="mx-auto">
    <div class="">
        <div class="symbol symbol-75px symbol-circle">
            <div class="symbol-label fs-2qx fw-bold text-success">{{ substr(Auth::user()->currentTeam->name , 0, 1) }}</div>
        </div>
        <div class="mt-4">
            <div class="cursor-pointer symbol" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                <span class="menu-title text-muted cursor-pointer">
                    {!! theme()->getSvgIcon("icons/duotone/Arrow/Switch.svg", "svg-icon-1") !!}
                    {{ __('Switch Team') }}
                </span>
            </div>
            <!--begin::Menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true">
                <!--begin::Menu item-->
                    @foreach (Auth::user()->allTeams() as $team)
                        <x-jet-switchable-team class="menu-item px-5" :team="$team" />
                    @endforeach
                <!--end::Menu item-->
            </div>
        </div>
    </div>
</div>
 
 <div class="separator my-10"></div>