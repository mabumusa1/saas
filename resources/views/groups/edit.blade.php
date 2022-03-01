<x-base-layout>
    <div class="container mb-8">
        <div class="row">
            <div class="col-3">
                <div class="card">

                    <div class="card-body">
                        <h5 class="card-title mb-10">{{ __('Groups') }}</h5>
                        @foreach ($groups as $grp)
                            <div class="mb-5">
                                @if ($grp->is($group))
                                    <span>
                                        <span class="d-block">{{ $grp->name }}</span>
                                        <span>{{ $grp->notes }}</span>
                                    </span>
                                @else
                                    <a href="{{ route('groups.edit', [$account->id, $grp->id]) }}">
                                        <span class="d-block">{{ $grp->name }}</span>
                                        <span>{{ $grp->notes }}</span>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                        <a class="btn btn-primary btn-sm" href="{{ route('groups.create', [$account->id])}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                              </svg>
                            {{ __('Add Group') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <h2 class="text-dark mb-8">{{ __('Edit Group') }}</h2>
                        <form action="{{ route('groups.update', compact('account', 'group')) }}" method="POST"
                            id="group-form" class="form mx-auto" novalidate="novalidate" autocomplete="off">

                            @csrf
                            @method('PUT')
                            <div class="mb-5">
                                <div class="mb-5">
                                    <label class="form-label">{{ __('Name *') }}</label>
                                    <input type="text" class="form-control" name="name" placeholder="{{ __('Group Name') }}"
                                        id="name" required value={{ $group->name }}>
                                </div>
                                <div class="">
                                    <label class="form-label">{{ __('Notes') }}</label>
                                    <textarea class="form-control" name="notes"
                                        placeholder="{{ __('Description') }}">{{ $group->notes }}</textarea>
                                </div>
                                <span class="text-muted ">{{ __('URLs will be converted into clickable links') }}</span>
                            </div>
                            <div class="mb-5">
                                <h5>{{ __('Add Sites to this group') }}</h5>
                                <div>
                                    <button type="button" class="btn btn-dark btn-sm" id="selectAll">{{ __('Select all') }}</button>
                                    <button type="button" class="btn btn-dark btn-sm" id="removeAll">{{ __('Remove all') }}</button>
                                </div>
                                <div class="mt-17">
                                    <div class="row">
                                        @foreach ($sites as $site)
                                            <div class="col-4 mb-15">
                                                <div class="form-check">
                                                    <input name="sites[]" class="form-check-input site" type="checkbox"
                                                        value="{{ $site->id }}"
                                                        {{ $group->hasSite($site) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $site->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-5">
                                        <button type="button" class="btn btn-danger btn-sm btn-delete"
                                            id="btn-submit">{{ __('Delete group') }}</button>
                                    </div>
                                    <div class="col-6 mb-5 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary btn-sm" id="btn-submit">
                                            {{ __('Update group') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('groups.destroy', compact('account', 'group')) }}" method="post" class="form-delete">
                            @csrf
                            @method('DELETE')
                        </form>
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
                        document.querySelector('.form-delete').submit();
                    }
                })
                });
            })

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
