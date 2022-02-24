<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5">
                    <h1>Account users</h1>
                </div>
                <div class="table-responsive">
                    <table class="table table-rounded table-row-bordered border gy-7 gs-7">
                        <thead>
                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                            <th>Full name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Account access</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user )
                            <tr>
                                <td>{{ $user->fullName }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ isset(roles()[$user->pivot->role]) ? roles()[$user->pivot->role] : '' }}</td>
                                <td><a href="{{ route('users.edit',[$currentAccount->id, $user->id]) }}">Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
