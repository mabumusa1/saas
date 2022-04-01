<x-base-layout>
    @include('installs.partials._toolbar')
    @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
    <div class="container p-0">
        <div class="row">
            <div class="col-3">
                @include('installs.partials._sidebar')
            </div>
            <div class="col-9">
                @yield('install_module')
            </div>
        </div>
    </div>
    @stack('modals')
    @push('scripts')
        <style>
            .btn-action {
                border-radius: 0%;
            }

        </style>
    @endpush
</x-base-layout>
