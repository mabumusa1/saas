@extends('installs.layout.default')
@section('install_module')
    {{--
        @include('installs.partials._goLiveChecklist')
    --}}
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 card-title">{{ __('Overview') }}</h2>
            <div class="card-toolbar">
                <a class="btn btn-primary btn-icon btn-sm px-4 px-lg-6 me-2 me-lg-3">
                    {!! get_svg_icon('skin/media/icons/duotone/Files/Cloud-download.svg') !!}
                </a>
                @if($install->owner === 'transferable')
                <button disabled class="btn btn-primary btn-icon btn-sm px-4 px-lg-6 me-2 me-lg-3">
                    {!! get_svg_icon('skin/media/icons/duotone/General/Lock.svg', 'svg-icon-2x') !!}
                </button>
                @else
                <form action="{{ route('installs.lock', ['account' => $currentAccount, 'site' => $site, 'install' => $install]) }}" method="post">
                    @csrf
                    <button class="btn btn-primary btn-icon btn-sm px-4 px-lg-6 me-2 me-lg-3">
                        {!! get_svg_icon('skin/media/icons/duotone/General/Lock.svg', 'svg-icon-2x') !!}
                    </button>
                </form>
                @endif
                @if ($site->installs->count() > 1)
                    <a id="btn-delete" class="btn btn-danger btn-sm btn-icon px-4 px-lg-6 me-2 me-lg-3">
                        {!! get_svg_icon('skin/media/icons/duotone/General/Trash.svg', 'svg-icon-2x') !!}
                    </a>
                @endif
            </div>
        </div>
        <div class="card-body">
        @include('installs.partials._installStatus')        
            @if ($install->owner === 'transferable')
                <div class="card card-bordered border-primary mb-5">
                    <div class="card-header bg-gray-200">
                        <h3 class="card-title">{{ __('Transferable install') }}</h3>
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                data-bs-target="#transfer_site_modal">
                                {{ __('Transfer Install') }}
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item border-0">Demo link:</li>
                            <li class="list-group-item border-0">User: demo</li>
                            <li class="list-group-item border-0 d-flex">Password: {!! get_svg_icon('skin/media/icons/duotone/General/Edit.svg', 'ms-2') !!}</li>
                        </ul>
                        <hr />
                        <p>
                            {{ __('Traffic to this install is restricted and password-protected. To unlock, transfer the
                                                                            install to another account or convert to a billable site. Learn more about
                                                                            transferable sites') }}
                        </p>
                    </div>
                </div>
            @endif
            {{--
                @include('installs.partials._helpMigrate')
            --}}
            <div class="card mt-6 bg-light-primary">
                <div class="card-header bg-gray-200">
                    <h3 class="card-title">{{ __('Install stats') }}</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <p class="fw-bold">{{ __('Primary domain:') }} </span> <a
                                    href="{{ route('domains.index', [$account, $site, $install]) }}">{{ __('Set primary domain') }}</a>
                            </p>
                            <p class="fw-bold">{{ __('Technical contact:') }} </span> <a
                                    href="{{ route('contacts.edit', [$account, $install->contact]) }}">{{ $install->contact->fullName }}</a>
                            </p>
                        </div>
                        <div class="col">
                            <p class="fw-bold">{{ __('CNAME:') }} </span> <a
                                    href="https://{{ $install->cname }}">{{ $install->cname }}</a></p>

                            <p class="fw-bold">{{ __('Created at:') }} </span>{{ $install->created_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($site->installs->count() > 1)
        <form id="delete_form" method="post"
            action="{{ route('installs.destroy', ['account' => $currentAccount, 'site' => $site, 'install' => $install]) }}">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('modals')
    @include('installs.partials.modals', [
        'install_id' => $install->id,
        'installs' => $installs,
    ])
@endpush

@push('scripts')
    @if ($site->installs->count() > 1)
        <script>
            document.querySelector('#btn-delete').addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.querySelector('#delete_form').submit();
                    }
                })
            });
        </script>
    @endif
@endpush
