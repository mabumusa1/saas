<?php
$links = [
    ['label' => __('Overview'), 'link' => route('installs.show', [$account, $site, $install])],
    ['label' => __('Domains'), 'link' => route('domains.index', [$account, $site, $install])],
    //['label' => __('CDN'), 'link' => route('installs.cdn', [$account, $site, $install])],
    //['label' => __('Redirect Rules'), 'link' => route('installs.redirectRules', [$account, $site, $install])],
    ['label' => __('Backups'), 'link' => route('backups.index', [$account, $site, $install])],
    //['label' => __('Access Logs'), 'link' => route('installs.accessLogs', [$account, $site, $install])],
    //['label' => __('Error Logs'), 'link' => route('installs.errorLogs', [$account, $site, $install])],
    //['label' => __('Utilities'), 'link' => route('installs.utilities', [$account, $site, $install])],
    //['label' => __('Caching'), 'link' => route('installs.caching', [$account, $site, $install])],
    //['label' => __('Site Migration'), 'link' => route('installs.migration', [$account, $site, $install])],
    //['label' => __('Go live checklist'), 'link' => route('installs.liveCheck', [$account, $site, $install])],
    //['label' => __('Web Rules'), 'link' => route('installs.webRules', [$account, $site, $install])],
    //['label' => __('Cron Commands'), 'link' => route('installs.cron', [$account, $site, $install])],
];

?>

<div class="card">
    <div class="card-body p-0">
        <span
            class="border border-primary d-block p-5 bg-primary text-white fs-5 fw-bold">{{ installType()[$install->type] }}</span>
        <nav class="nav flex-column">
            @foreach ($links as $link)
                <a href="{{ $link['link'] }}"
                    class="nav-link d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ $link['label'] }}</a>
            @endforeach
        </nav>
        @if ($install->type !== 'prd')
            @if ($site->hasInstallType('prd'))
                @php
                    $prdInstall = $site->installs->where('type', 'prd')->first();
                @endphp
                <a href="{{ route('installs.show', ['account' => $account, 'site' => $site, 'install' => $prdInstall->id]) }}"
                    class="btn border-square border w-100 text-start border-primary">
                    <span class="badge badge-primary me-3">{{ __('PRd') }}</span>
                    {{ $prdInstall->name }}
                </a>
            @else
                <a href="{{ route('installs.create', ['account' => $currentAccount, 'site' => $site]) }}?env=prd"
                    class="btn border-square border border-bottom-1 border-gray-400 w-100 text-start">{!! get_svg_icon('icons/duotone/Navigation/Plus.svg', 'svg-icon-dark svg-icon-2') !!}Add
                    Production</a>
            @endif
        @endif
        @if ($install->type !== 'dev')
            @if ($site->hasInstallType('dev'))
                @php
                    $devInstall = $site->installs->where('type', 'dev')->first();
                @endphp
                <a href="{{ route('installs.show', ['account' => $account, 'site' => $site, 'install' => $devInstall->id]) }}"
                    class="btn border-square border w-100 text-start border-primary">
                    <span class="badge badge-info me-3">{{ __('DEV') }}</span>
                    {{ $devInstall->name }}
                </a>
            @else
                <a href="{{ route('installs.create', ['account' => $currentAccount, 'site' => $site]) }}?env=dev"
                    class="btn border-square border w-100 text-start border-primary">{!! get_svg_icon('icons/duotone/Navigation/Plus.svg', 'svg-icon-dark svg-icon-2') !!}
                    {{ __('Add Dev Install') }}
                </a>
            @endif
        @endif
    </div>
</div>
