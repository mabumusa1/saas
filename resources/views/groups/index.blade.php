<x-base-layout>
    <div class="container mb-8">
        <div class="row">
            <div class="col-3">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title mb-10">Groups</h5>
                        @foreach ($groups as $grp)
                            <div class="mb-5">
                                <a href="{{ route('groups.edit', [$account->id, $grp->id]) }}">
                                    <span class="d-block">{{ $grp->name }}</span>
                                    <span>{{ $grp->notes }}</span>
                                </a>
                            </div>
                        @endforeach
                        <a class="btn btn-primary btn-sm" href={{ route('groups.create', [$account->id])}}>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                              </svg>
                            Add Group</a>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-dark mb-8">Edit Group</h2>
                        <div class="alert alert-success">Please select a group</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            document.querySelector('#selectAll').addEventListener('click', function() {
                document.querySelectorAll('.site').forEach(function(el) {
                    el.checked = true;
                })
            });
            document.querySelector('#removeAll').addEventListener('click', function() {
                document.querySelectorAll('.site').forEach(function(el) {
                    el.checked = false;
                })
            });

            @if (session()->has('success'))

                toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toastr-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
                };

                toastr.success("{{ session()->get('success') }}");
            @endif
        </script>
    @endpush
</x-base-layout>
