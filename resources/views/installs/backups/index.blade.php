@extends('installs.layout.default')
@section('install_module')
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0 card-title">{{ __('Backup Points') }}</h2>
            <div class="card-toolbar">
                <button class="btn btn-sm border-square btn-dark me-1">Restore</button>
                <button class="btn btn-sm border-square btn-dark me-1">Download ZIP</button>
                <button class="btn btn-sm border-square btn-primary">Back up now</button>
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
            </table>
        </div>
    </div>
@endsection
