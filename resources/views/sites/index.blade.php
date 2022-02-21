<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-10 col-12 border p-10">
                    <div class="d-flex justify-content-between mb-5">
                        <h1>Sites</h1>
                        <a href="{{ route('sites.create', $currentAccount->id) }}" class="btn btn-primary">Add Site</a>
                    </div>
                    <h5 class="text-muted">Search for site, domain, environment</h4>
                        <form id="filters">
                            <div class="row">
                                <div class="col-5 mb-4">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control border-right-0" name="q"
                                            value="{{ request()->get('q') }}" />
                                        <span class="input-group-text bg-transparent" id="basic-addon2"><i
                                                class="bi bi-search"></i></span>
                                    </div>
                                </div>
                                <div class="col-7 d-flex justify-content-end align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            {{ request()->has('env') ? 'checked' : '' }} id="show_env" name="env">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Show Environments
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">

                            <table class="table table-rounded table-row-bordered border gy-7 gs-7">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>Site Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sites as $site)
                                        <tr>
                                            <td>{{ $site->name }}</td>
                                            <td><a
                                                    href="{{ route('sites.edit', [$currentAccount->id, $site->id]) }}">Edit</a>
                                            </td>
                                        </tr>
                                        @foreach ($site->installs as $install)
                                            <tr>
                                                <td class="table-light">
                                                    <div class="env {{ request()->has('env') ?: 'd-none' }}">
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
                                                    </div>
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
    @section('scripts')
        <script>
            const showEnv = document.getElementById('show_env');


            showEnv.addEventListener('change', function() {
                let searchParams = new URLSearchParams(window.location.search);
                if (showEnv.checked) {
                    document.querySelectorAll('.env').forEach(function(el) {
                        el.classList.remove('d-none');
                    });
                    searchParams.set('env', 'on');
                } else {
                    document.querySelectorAll('.env').forEach(function(el) {
                        el.classList.add('d-none');
                    });
                    searchParams.delete('env');
                }
                if (history.pushState) {
                    let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname +
                        '?' + searchParams.toString();
                    window.history.pushState({
                        path: newurl
                    }, '', newurl);
                }
            });
        </script>
    @endsection
</x-base-layout>
