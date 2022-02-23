<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-10 col-12">
                    <div class="d-flex justify-content-between mb-5">
                        <h1>Sites</h1>
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
                                            {{ request()->has('env') ? (request()->get('env') == 1 ? 'checked' : '') : 'checked' }}
                                            id="show_env" name="env">
                                        <label class="form-check-label" for="flexCheckDefault">
                                            Show Environments
                                        </label>
                                    </div>
                                    <a class="btn btn-link btn-sm ms-5"
                                        href="{{ route('groups.index', $currentAccount->id) }}">Manage group</a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">

                            <table class="table table-rounded border gy-7 gs-7">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200 table-active">
                                        <th id="sortable">Site Name<i
                                                class="bi {{ $order === 'ASC' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                        </th>
                                        <th>Groups</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sites as $site)
                                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                            <td>{{ $site->name }}</td>
                                            <td>
                                                @foreach ($site->groups as $group)
                                                    <span class="badge badge-secondary">{{ $group->name }}</span>
                                                @endforeach
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('sites.edit', [$currentAccount->id, $site->id]) }}"><i class="bi bi-pencil"></i></a>
                                                <form
                                                action="{{ route('sites.destroy', [$currentAccount->id, $site->id]) }}"
                                                class="d-inline" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm btn-delete"><i class="bi bi-archive"></i></button>
                                            </form>

                                            </td>
                                        </tr>
                                        @foreach ($site->installs as $install)
                                            <tr
                                                class="env {{ request()->has('env') ? (request()->get('env') == 1 ? '' : 'd-none') : '' }}">
                                                <td class="table-light">
                                                    <i class="bi bi-arrow-90deg-right"></i>
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
                                                    <p class="d-inline">{{ $install->name }}</p>
                                                </td>
                                                <td class="table-light"></td>

                                                <td class="table-light text-center">
                                                    <!--begin::Trigger-->
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                    data-kt-menu-trigger="click"
                                                    data-kt-menu-placement="bottom-start">
                                                    <span class="svg-icon svg-icon-5 ms-3 me-0"><i class="bi bi-three-dots-vertical"></i></span>
                                                    </button>
                                                    <!--end::Trigger-->
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
                                                    data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">
                                                                Backup Install
                                                            </a>
                                                            <a href="#" class="menu-link px-3">
                                                                Clear Cache
                                                            </a>
                                                            <a href="#" class="menu-link px-3">
                                                                Delete Install
                                                            </a>

                                                        </div>
                                                        <!--end::Menu item-->
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
    @push('scripts')
        <style>
            .form-control:focus+.input-group-text {
                border-color: #B5B5C3
            }

            #sortable {
                cursor: pointer;
            }

            #sortable:hover {
                background-color: lightgray;
            }

            .btn-delete{
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }
        </style>
        <script>
            var showEnv = document.getElementById('show_env');


            showEnv.addEventListener('change', function() {
                let searchParams = new URLSearchParams(window.location.search);
                if (showEnv.checked) {
                    document.querySelectorAll('.env').forEach(function(el) {
                        el.classList.remove('d-none');
                    });
                    searchParams.set('env', '1');
                } else {
                    document.querySelectorAll('.env').forEach(function(el) {
                        el.classList.add('d-none');
                    });
                    searchParams.set('env', '0');
                }
                if (history.pushState) {
                    let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname +
                        '?' + searchParams.toString();
                    window.history.pushState({
                        path: newurl
                    }, '', newurl);
                }
            });
            var sortable = document.querySelector('#sortable');
            sortable.addEventListener('click', function() {
                let searchParams = new URLSearchParams(window.location.search);
                searchParams.set('order', "{{ $order === 'ASC' ? 'DESC' : 'ASC' }}");
                let newurl = window.location.protocol + "//" + window.location.host + window.location.pathname +
                    '?' + searchParams.toString();
                location.href = newurl;

            });
        </script>
    @endpush
</x-base-layout>
