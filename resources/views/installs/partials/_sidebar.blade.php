<div class="card">
    <div class="card-body p-0">
        <span class="border border-left-5 border-primary d-block p-5">{{ __('Production') }}</span>
        <a
            href="{{ route('installs.show', [$account, $site, $install]) }}" class="d-block p-2 ps-7 border border-bottom-0 border-top-0 border-gray-400">{{ __('Overview') }}</a>
        <a href="{{ route('domains.index', [$account, $site, $install]) }}"
            class="d-block p-2 ps-7 border border-bottom-1 border-top-0 border-gray-400">{{ __('Domains') }}</a>
    </div>
</div>
