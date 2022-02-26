<x-base-layout>
    <div class="card mb-5 mb-xl-10">
        <div class="card-body">
            <!--begin::Title-->
            <h3 class="mb-5">My Invoices</h3>
            <div class="">
                <table class="table table-responsive table-rounded border">
                    <thead>
                        <tr class="fw-bold fs-6 text-gray-800 border border-gray-200 table-active">
                            <th>Name</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($subscriptions as $subscription)
                            <tr class="fw-bold fs-6 text-gray-800 border border-gray-200">
                                <td>{{ $subscription->name }}</td>
                                <td>{{ $subscription->quantity }}</td>
                                <td>
                                    <button class="btn btn-danger btn-cancel"
                                        data-id="{{ $subscription->id }}">Cancel</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.querySelectorAll('.btn-cancel').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You're about to cancel your subscription!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, cancel it!'
                    }).then((result) => {
                        Swal.fire({
                            title: 'Please Wait!',
                            text: 'Cancelling your subscription...',
                            showCancelButton: false,
                            showConfirmButton: false,
                            allowEnterKey: false,
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            didOpen: function() {
                                Swal.showLoading()
                            }
                        })
                        if (result.value) {
                            const id = e.target.getAttribute('data-id');
                            axios.post('subscriptions/' + id + '/cancel')
                                .then(function(response) {
                                    Swal.fire(
                                        'Cancelled!',
                                        'Your subscription has been cancelled.',
                                        'success'
                                    )
                                    window.location.reload();
                                })
                                .catch(function(error) {
                                    Swal.fire(
                                        'Error!',
                                        'There was an error cancelling your subscription.',
                                        'error'
                                    )
                                });
                        }
                    })
                })
            })
        </script>
    @endpush
</x-base-layout>
