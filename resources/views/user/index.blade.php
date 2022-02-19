<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5">
                    <h1>Account users</h1>
                    <a href="{{ route('users.create','2') }}" class="btn btn-primary">Add User</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-rounded table-row-bordered border gy-7 gs-7">
                        <thead>
                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Account access</th>
                            <th>Install access</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>+125090-1285-01</td>
                            <td>61</td>
                            <td>2011/04/25</td>
                            <td><a href="{{ route('users.edit',['2','2']) }}">Edit</a></td>
                        </tr>
                        <tr class="table-active">
                            <td>Garrett Winters</td>
                            <td>Accountant</td>
                            <td>+125090-1285-01</td>
                            <td>63</td>
                            <td>2011/07/25</td>
                            <td><a href="{{ route('users.edit',['2','2']) }}">Edit</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-base-layout>
