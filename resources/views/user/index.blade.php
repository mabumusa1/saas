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
                                            <a
                                                href="{{ route('users.edit', [$currentAccount->id, $user->id]) }}">{{ __('Edit') }}</a>
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
    <div class="modal fade" tabindex="-1" id="add_user_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>
                <form action="{{ route('users.store', $currentAccount->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-10">
                            <label for="email">Email</label>
                            <input name="email" id="email" type="email" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label class="required text-lg-start">{{ __('Account access') }}</label>

                            <a href="#" class="float-end">{{ __('View access type definitions') }}</a>
                            <select  name="role" class="form-select form-select-solid" aria-label="Select example">
                                @foreach(roles() as $roleKey => $roleValue)
                                    @if($roleKey === 'admin' && $currentAccount->users()->where('users.id', request()->user()->id)->first()->pivot->role !== 'admin')
                                    @continue
                                    @endif
                                    <option value="{{$roleKey}}">{{$roleValue}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('role'))
                                <span class="help-block"><strong>{{ $errors->first('role') }}</strong></span>
                            @endif
                        </div>
                    </div>



                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-base-layout>
