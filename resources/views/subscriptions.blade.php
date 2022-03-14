<x-base-layout>

    <div class="container mb-8">
        @if (session()->has('error'))
            <div class="alert alert-danger text-center">
                {{ session()->get('error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="mb-10 col-12">
                    <div class="d-flex justify-content-between mb-5">
                        <h1>Subscriptions</h1>
                    </div>
                    <div class="table-responsive">

                        <table class="table table-rounded border gy-7 gs-7">
                            <thead>
                                <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200 table-active">
                                    <th id="sortable">Plan</th>
                                    <th>Quantity</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscriptions as $subscription)
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <td>{{ $subscription->name }}</td>
                                        <td>{{ $subscription->quantity }}</td>
                                        <td>
                                            <button class="btn btn-success btn-sm btn-qty"
                                                data-id="{{ $subscription->id }}" data-bs-toggle="modal"
                                                data-bs-target="#modal-qty" data-qty="{{ $subscription->quantity }}">
                                                Change Quantity
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="modal-qty">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Quantity</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black"></rect>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)"
                                    fill="black"></rect>
                            </svg>
                        </span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <form action="#" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="input-group" data-kt-dialer="true" data-kt-dialer-min="1"
                            data-kt-dialer-max="100" data-kt-dialer-step="1">

                            <!--begin::Decrease control-->
                            <button class="btn btn-icon btn-outline btn-outline-secondary" type="button"
                                data-kt-dialer-control="decrease">
                                <i class="bi bi-dash fs-1"></i>
                            </button>
                            <!--end::Decrease control-->

                            <!--begin::Input control-->
                            <input id="qty" name="qty" type="text" class="form-control text-center" readonly
                                placeholder="Amount" value="" data-kt-dialer-control="input" />
                            <!--end::Input control-->

                            <!--begin::Increase control-->
                            <button class="btn btn-icon btn-outline btn-outline-secondary" type="button"
                                data-kt-dialer-control="increase">
                                <i class="bi bi-plus fs-1"></i>
                            </button>
                            <!--end::Increase control-->
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submit">Submit</button>
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
            document.querySelectorAll('.btn-qty').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var id = this.getAttribute('data-id');
                    var qty = this.getAttribute('data-qty');
                    document.querySelector('#qty').value = qty;
                    document.querySelector('#modal-qty form').setAttribute('action',
                        `{{ route('subscriptions.index', [$account]) }}/${id}`);
                });
            });
            document.querySelector('#submit').addEventListener('click', function() {
                document.querySelector('#modal-qty form').submit();
            })
        </script>
    @endpush
</x-base-layout>
