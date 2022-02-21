<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-10 col-12 border p-10">
                    <div class="d-flex justify-content-between mb-5">
                        <h1>Groups</h1>
                        <a href="{{ route('groups.create', $currentAccount->id) }}" class="btn btn-primary">Add
                            Group</a>
                    </div>
                    <h5 class="text-muted">Search for group</h4>
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
                            </div>
                        </form>
                        <div class="table-responsive">

                            <table class="table table-rounded table-row-bordered border gy-7 gs-7">
                                <thead>
                                    <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                        <th>Name</th>
                                        <th>Notes</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groups as $group)
                                        <tr>
                                            <td>{{ $group->name }}</td>
                                            <td>{{ $group->notes }}</td>
                                            <td>
                                                <div>
                                                    <a href="{{ route('groups.edit', compact('account', 'group')) }}"
                                                        class="btn btn-warning btn-sm">Edit</a>
                                                    <form
                                                        action="{{ route('groups.destroy', compact('account', 'group')) }}"
                                                        method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            id="btn-submit">Delete</button>
                                                    </form>
                                                </div>
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
    @section('scripts')
        <style>
            .form-control:focus + .input-group-text {
                border-color: #B5B5C3
            }

        </style>
    @endsection
</x-base-layout>
