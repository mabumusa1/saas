@extends('installs.layout.default')
@section('install_module')
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 card-title">{{ __('Backup Points') }}</h2>
            <div class="card-toolbar">
                <button class="btn btn-sm border-square btn-dark me-1">Restore</button>
                <button class="btn btn-sm border-square btn-dark me-1">Download ZIP</button>
                <button class="btn btn-sm border-square btn-primary"
                data-bs-toggle="modal" data-bs-target="#backup_install_modal"
                >Back up now</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr class="fw-bold fs-4 bg-gray-400">
                        <th></th>
                        <th>Date and time (UTC)</th>
                        <th>Description</th>
                        <th>ID</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($backups as $backup)
                    <tr>
                        <td></td>
                        <td>
                            {{ $backup->created_at->format('m/d/Y h:i:s A') }}
                            <span class="text-muted">{{ $backup->created_at->diffForHumans() }}</span>
                        </td>
                        <td>{{ $backup->description }}</td>
                        <td>{{ $backup->id }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="backup_install_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Backup Install') }}</h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <form action="{{ route('backups.store', ['account' => $account, 'install' => $install, 'site' => $site]) }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-10">
                            <label for="description">Descriptions</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Backup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
