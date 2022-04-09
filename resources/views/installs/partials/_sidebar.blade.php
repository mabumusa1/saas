<div class="card">
    <div class="card-body p-0">
        <span class="border border-left-5 border-primary d-block p-5">{{ __('Production') }}</span>
        <a href="{{ route('installs.show', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Overview') }}</a>
        <a href="{{ route('domains.index', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Domains') }}</a>
        <a href="{{ route('installs.cdn', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('CDN') }}</a>
        <a href="{{ route('installs.redirectRules', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Redirect Rules') }}</a>
        <a href="{{ route('installs.backupPoints', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Backup points') }}</a>
        <a href="{{ route('installs.accessLogs', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Access Logs') }}</a>
        <a href="{{ route('installs.errorLogs', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Error Logs') }}</a>
        <a href="{{ route('installs.utilities', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Utilities') }}</a>
        <a href="{{ route('installs.caching', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Caching') }}</a>
        <a href="{{ route('installs.migration', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Site Migration') }}</a>
        <a href="{{ route('installs.liveCheck', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Go live checklist') }}</a>
        <a href="{{ route('installs.webRules', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Web Rules') }}</a>
        <a href="{{ route('installs.cron', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Cron Commands') }}</a>
        @if (!$site->hasInstallType('prd'))
            <a href="{{ route('installs.create', ['account' => $currentAccount, 'site' => $site]) }}?env=prd"
                class="btn border-square border border-bottom-1 border-gray-400 w-100 text-start">{!! get_svg_icon('icons/duotone/Navigation/Plus.svg', 'svg-icon-dark svg-icon-2') !!}Add
                Production</a>
        @endif
        @if (!$site->hasInstallType('stg'))
            <a href="{{ route('installs.create', ['account' => $currentAccount, 'site' => $site]) }}?env=stg"
                class="btn border-square border border-bottom-1 border-gray-400 w-100 text-start">{!! get_svg_icon('icons/duotone/Navigation/Plus.svg', 'svg-icon-dark svg-icon-2') !!}Add
                Staging</a>
        @endif
        @if (!$site->hasInstallType('dev'))
            <a href="{{ route('installs.create', ['account' => $currentAccount, 'site' => $site]) }}?env=dev"
                class="btn border-square border border-bottom-1 border-gray-400 w-100 text-start">{!! get_svg_icon('icons/duotone/Navigation/Plus.svg', 'svg-icon-dark svg-icon-2') !!}Add Dev</a>
        @endif
    </div>
</div>
