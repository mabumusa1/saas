<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-10 col-12 border p-10">
                    <div class="d-flex justify-content-between mb-5">
                        <h1>{{ __('Technical Contacts') }}</h1>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-rounded table-row-bordered border gy-7 gs-7">
                            <thead>
                            <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>{{ __('Install Name') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{ __('Phone') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($currentAccount->sites as $site )
                                    @foreach ($site->installs as $install )
                                        <tr>
                                            <td>
                                                {{ $install->name }}
                                                @switch($install->type)
                                                @case('prd')
                                                    <span class="badge badge-success">{{ __('PRD') }}</span>
                                                @break
                                                @case('dev')
                                                    <span class="badge badge-light-dark">{{ __('DEV') }}</span>
                                                @break
                                            @endswitch

                                            </td>
                                            <td>{{ $install->contact->fullName }}</td>
                                            <td>{{ $install->contact->email }}</td>
                                            <td>{{ $install->contact->phone }}</td>
                                            <td><a href="{{ route('contacts.edit',[$currentAccount->id, $install->contact->id]) }}">{{ __('Edit') }}</a></td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-base-layout>
