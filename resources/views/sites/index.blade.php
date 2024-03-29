<x-base-layout>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-10 col-12">
                    <div class="d-flex justify-content-between mb-5">
                        <h1>{{ __('Sites') }}</h1>
                    </div>
                    <h4 class="text-muted">{{ __('Search for site, domain, install') }}</h4>
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
                                        {{ __('Show Installs') }}
                                    </label>
                                </div>
                                <a class="btn btn-link btn-sm ms-5"
                                    href="{{ route('groups.index', $currentAccount->id) }}">{{ __('Manage group') }}</a>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">

                        <table class="table table-rounded border gy-7 gs-7">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200 table-active">
                                    <th id="sortable">{{ __('Site Name') }}<i
                                            class="bi {{ $order === 'ASC' ? 'bi-arrow-up' : 'bi-arrow-down' }}"></i>
                                    </th>
                                    <th>{{ __('Groups') }}</th>
                                    <th class="text-center">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sites as $site)
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <td>{{ $site->name }}<br/><a class="text-muted small text-hover-primary" href="{{ route('sites.edit', [$currentAccount->id, $site->id]) }}">Edit</a></td>
                                        <td>
                                            @foreach ($site->groups as $group)
                                                <span class="badge badge-secondary">{{ $group->name }}</span>
                                            @endforeach
                                        </td>
                                                                            </tr>
                                    @foreach ($site->installs as $install)
                                        <tr
                                            class="env {{ request()->has('env') ? (request()->get('env') == 1 ? '' : 'd-none') : '' }}">
                                            <td class="table-light">
                                                <a
                                                    href="{{ route('installs.show', ['account' => $currentAccount->id, 'site' => $site->id, 'install' => $install->id]) }}">
                                                    <i class="bi bi-arrow-90deg-right"></i>
                                                </a>
                                                @switch($install->type)
                                                    @case('prd')
                                                        <span class="badge badge-success">{{ __('PRD') }}</span>
                                                    @break
                                                    @case('dev')
                                                        <span class="badge badge-light-dark">{{ __('DEV') }}</span>
                                                    @break
                                                @endswitch
                                                <a href="{{ route('installs.show', [$currentAccount->id, $site->id, $install->id]) }}"
                                                    class="d-inline">{{ $install->name }}</p>
                                            </td>
                                            <td class="table-light"></td>

                                            <td class="table-light text-center">
                                                <!--begin::Trigger-->
                                                <button type="button" class="btn btn-primary btn-sm btn-icon"
                                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                                    <span class="svg-icon svg-icon-5"><i
                                                            class="bi bi-three-dots-vertical"></i></span>
                                                </button>
                                                <!--end::Trigger-->
                                                <!--begin::Menu-->
                                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-200px py-4"
                                                    data-kt-menu="true">
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item px-3">
                                                        <a href="!#" class="menu-link px-3 btn-backup" data-bs-toggle="modal" data-bs-target="#site_backup_modal" data-install="{{ $install->id }}" data-site="{{ $site->id }}">
                                                            {{ __('Backup Install') }}
                                                        </a>
                                                        <a href="!#" data-href="{{ route('installs.destroy', ['account' => $currentAccount, 'site' => $site, 'install' => $install]) }}" class="menu-link px-3 btn-install-delete">
                                                            {{ __('Delete Install') }}
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
    <form
    id="install_delete_form" method="post">
        @csrf
        @method('DELETE')
    </form>
    <div class="modal fade" tabindex="-1" id="accept_transfer_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Accept Site Transfer') }}</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <form action="{{ route('transfer.check', [$currentAccount->id]) }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group mb-10">
                            <label for="code">Code</label>
                            <input name="code" id="code" type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Accept') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="site_backup_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Backup Site Install') }}</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <form action="!#" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group mb-10">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Backup') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
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
            var backup = document.querySelectorAll('.btn-backup');
            backup.forEach(function(el) {
                el.addEventListener('click', function() {
                    let site = el.dataset.site;
                    let install = el.dataset.install;
                    let url = "{{ route('backups.store', [$currentAccount->id, ':site', ':install']) }}".replace(':site', site).replace(':install', install);
                    $('#site_backup_modal form').attr('action', url);
                });
            });
            var deleteBtn = document.querySelectorAll('.btn-delete');
            deleteBtn.forEach(function(button) {
                button.addEventListener('click', function(e) {
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
                            document.querySelector(button.getAttribute('data-target')).submit();
                        }
                    })
                });
            })

            var deleteBtn = document.querySelectorAll('.btn-install-delete');
            deleteBtn.forEach(function(button) {
                button.addEventListener('click', function(e) {
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
                            var deleteForm = document.querySelector('#install_delete_form');
                            deleteForm.action = button.getAttribute('data-href');
                            deleteForm.submit();
                        }
                    })
                });
            })
        </script>
    @endpush
</x-base-layout>
