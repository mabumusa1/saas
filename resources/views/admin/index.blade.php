<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-rounded table-row-bordered border gy-7 gs-7">
                        <thead>
                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                            <th>#</th>
                            <th>{{ __('Full name') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $account)
                                <tr>
                                    <td>{{ $account->id }}</td>
                                    <td>{{ $account->name }}</td>
                                    <td>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        {{ __('User Full Name') }}
                                                    </th>
                                                    <th>
                                                        {{ __('Login as') }}
                                                    </th>
                                                    <th>
                                                        {{ __('Role') }}
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($account->users as $user )
                                                <tr>
                                                    <td>
                                                    {{ $user->fullName }}
                                                    </td>
                                                    <td>
                                                        @canBeImpersonated($user, $guard = null)
                                                        <a href="{{ route('impersonate', $user->id) }}" class="btn btn-warning btn-sm">{{ __('Login As') }}</a>
                                                        @endCanBeImpersonated
                                                    </td>
                                                    <td>
                                                        {{ roles()[$user->pivot->role] }}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>