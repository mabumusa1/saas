<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-10 col-12 border p-10">
                    <div class="d-flex justify-content-between mb-5">
                        <h1>Sites</h1>
                        <a href="{{ route('sites.create', $currentAccount->id) }}" class="btn btn-primary">Add Site</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-rounded table-row-bordered border gy-7 gs-7">
                            <thead>
                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>Site Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($sites as $site )
                                    <tr>
                                        <td>{{ $site->name }}</td>
                                        <td><a href="{{ route('sites.edit',[$currentAccount->id, $site->id]) }}">Edit</a></td>
                                    </tr>
                                    @foreach ( $site->installs as $install )
                                    <tr>
                                        <td class="table-light">
                                            @switch($install->type)
                                                @case('prd')
                                                    <span class="badge badge-success">PRD</span>
                                                @break
                                                @case('stg')
                                                    <span class="badge badge-light-success">STG</span>
                                                @break
                                                @case('dev')
                                                    <span class="badge badge-light-dark">DEV</span>
                                                @break
                                            @endswitch
                                            <p>{{ $install->name }}</p>
                                        </td>
                                        <td class="table-light">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a class="btn btn-sm btn-primary" href="#">Backup Install</a>
                                                <a class="btn btn-sm btn-primary" href="#"> Clear Cache</a>
                                                <a class="btn btn-sm btn-danger" href="#"> Delete Install</a>
                                              </div>                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-base-layout>