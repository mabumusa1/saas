<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-5">
                    <h1>Log</h1>
                </div>
                @if(Gate::allows('isAdmin'))
                    <h4 class="text-muted">{{ __('Search by account Id') }}</h4>
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
                @endif
                <div class="table-responsive">
                    <table class="table table-rounded table-row-bordered border gy-7 gs-7">
                        <thead>
                        <tr class="fw-bold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                            <th>{{ __('Activity') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('By') }}</th>
                            <th>{{ __('On') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $activity)
                            <tr>

                                <td>{{ $activity->log_name }}</td>
                                <td>{{ $activity->description }}</td>
                                <td>{{ $activity->causer->fullName }}</td>
                                <td>{{ $activity->created_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
