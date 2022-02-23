<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-10">Edit Site</h5>
                <div class="mb-10 col-12">
                    <div class="d-flex justify-content-between mb-5">
                        <form action="{{ route('sites.update', compact('account', 'site')) }}" method="POST"
                            id="group-form" class="form mx-auto" novalidate="novalidate" autocomplete="off">

                            @csrf
                            @method('PUT')
                            <div class="mb-5">
                                <div class="mb-5">
                                    <label class="form-label">Name *</label>
                                    <input type="text" class="form-control" name="name" placeholder="Group Name"
                                        id="name" required value={{ $site->name }}>
                                </div>
                            </div>
                            <div class="mb-5">
                                <h5>Assign Site to groups</h5>
                                <div>
                                    <button type="button" class="btn btn-dark btn-sm" id="selectAll">Select all</button>
                                    <button type="button" class="btn btn-dark btn-sm" id="removeAll">Remove all</button>
                                </div>
                                <div class="mt-17">
                                    <div class="row">
                                        @foreach ($groups as $group)
                                            <div class="col-4 mb-15">
                                                <div class="form-check">
                                                    <input name="groups[]" class="form-check-input site" type="checkbox"
                                                        value="{{ $group->id }}"
                                                        {{ $group->hasSite($site) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $group->name }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end"><button type="submit" class="ml-auto btn btn-primary btn-sm" id="btn-submit">Update site</button></div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
    @section('scripts')
=======
    @push('scripts')
>>>>>>> 0fed0b7d4a90ba2a4f2787d1d9e69ba69fbba309
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
        </script>
<<<<<<< HEAD
    @endsection
=======
    @endpush
>>>>>>> 0fed0b7d4a90ba2a4f2787d1d9e69ba69fbba309
</x-base-layout>
