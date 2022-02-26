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
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a class="btn btn-warning btn-sm text-white"
                                                        href="{{ route('sites.edit', [$currentAccount->id, $site->id]) }}">
                                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <g id="Stockholm-icons-/-General-/-Edit" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                                            <path d="M7.10343995,21.9419885 L6.71653855,8.03551821 C6.70507204,7.62337518 6.86375628,7.22468355 7.15529818,6.93314165 L10.2341093,3.85433055 C10.8198957,3.26854411 11.7696432,3.26854411 12.3554296,3.85433055 L15.4614112,6.9603121 C15.7369117,7.23581259 15.8944065,7.6076995 15.9005637,7.99726737 L16.1199293,21.8765672 C16.1330212,22.7048909 15.4721452,23.3869929 14.6438216,23.4000848 C14.6359205,23.4002097 14.6280187,23.4002721 14.6201167,23.4002721 L8.60285976,23.4002721 C7.79067946,23.4002721 7.12602744,22.7538546 7.10343995,21.9419885 Z" id="Path-11" fill="#000000" fill-rule="nonzero" transform="translate(11.418039, 13.407631) rotate(-135.000000) translate(-11.418039, -13.407631) "></path>
                                                        </g>
                                                    </svg>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm btn-delete"
                                                        data-target=".delete_form{{ $site->id }}">
                                                        <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                                            <g id="Stockholm-icons-/-General-/-Trash" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect id="bound" x="0" y="0" width="24" height="24"></rect>
                                                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" id="round" fill="#fff" fill-rule="nonzero"></path>
                                                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" id="Shape" fill="#fff"></path>
                                                            </g>
                                                        </svg>
                                                    </button>

                                                </div>
                                                <form
                                                    action="{{ route('sites.destroy', [$currentAccount->id, $site->id]) }}"
                                                    class="delete_form{{ $site->id }}" method="post">
                                                    @csrf
                                                    @method('DELETE')

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
                                                    <button type="button" class="btn btn-primary btn-sm btn-icon"
                                                    data-kt-menu-trigger="click"
                                                    data-kt-menu-placement="bottom-start">
                                                    <span class="svg-icon svg-icon-5"><i class="bi bi-three-dots-vertical"></i></span>
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
                                    @if(!count($sites))
                                    <tr>
                                        <td colspan="3" class="p-0">
                                            <div class="alert alert-success m-0">
                                                <p class="text-center">You have no sites.</p>
                                                <a href="{{ route('payment.checkout', $currentAccount->id) }}" class="btn btn-success d-block">Checkout</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endif
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
            .btn-delete {
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
            var deleteBtn = document.querySelectorAll('.btn-delete');
            deleteBtn.forEach(function(button){
                button.addEventListener('click', function(e){
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
        </script>
    @endpush
</x-base-layout>
