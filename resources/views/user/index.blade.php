<x-base-layout>
    @error('email')
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @enderror
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5">
                    <h1>{{ __('Account users') }}</h1>
                </div>
                <div class="table-responsive">
                    <table class="table table-rounded table-row-bordered border gy-7 gs-7">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>{{ __('Full name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Account access') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->fullName }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ roles()[$user->pivot->role] }}
                                    </td>
                                    @can('update', request()->user())
                                        <td>
                                            <button data-id="{{ $user->id }}" data-bs-toggle="modal"
                                                data-bs-target="#edit_user_modal"
                                                class="btn btn-link btn-sm btn-active-color-primary btn-edit">{{ __('Edit') }}</button>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('user.models')
    @push('scripts')
        <script>
            document.querySelectorAll('.btn-edit').forEach(function(el) {
                el.addEventListener('click', function() {
                    var form = document.querySelector('#edit_form')
                    form.action =
                        "{{ route('users.update', ['account' => $currentAccount->id, 'user' => '__user__']) }}"
                        .replace('__user__', el.dataset.id)
                })
            })
        </script>
    @endpush
</x-base-layout>
