<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class=" mb-5">
                    <h1>Edit user</h1>
                    <div class="separator mb-5"></div>
                </div>
                <form action="{{ route('users.update', ['account' => $account, 'user' => $user])}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-10 col-12 border p-10">
                    <div class="mb-10">
                        <div class="form-group fv-row">
                            <label class="required">First Name</label>
                            <input name="first_name" type="text" value="{{$user->first_name}}"
                                   class="form-control form-control-solid" placeholder=""/>
                            @if ($errors->has('first_name'))
                                <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-10">
                        <div class="form-group fv-row">
                            <label class="required">Last Name</label>
                            <input name="last_name" value="{{$user->last_name}}" type="text"
                                   class="form-control form-control-solid" placeholder=""/>
                            @if ($errors->has('last_name'))
                                <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-10">
                        <div class="form-group fv-row">
                            <label class="required">Email</label>
                            <input name="email" value="{{$user->email}}" type="text"
                                   class="form-control form-control-solid" placeholder=""/>
                            @if ($errors->has('email'))
                                <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group fv-row col-5 my-4">
                        <label class="required text-lg-start">Account access</label>
                        <a href="#" class="float-end">View access type definitions</a>
                        <select name="role" class="form-select form-select-solid" aria-label="Select example">
                            <option value="">Open this select menu</option>
                            @foreach(roles() as $roleKey => $roleValue)

                                <option @if($user->accountUser->role == $roleKey) selected @endif value="{{$roleKey}}">{{$roleValue}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role'))
                            <span class="help-block"><strong>{{ $errors->first('role') }}</strong></span>
                        @endif
                    </div>
                    <div class="separator mb-5"></div>
                    <div class="my-4">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_1">
                            <i class="bi bi-dash-circle fs-4 me-2"></i>Remove user
                        </button>
                        <button type="submit" class="btn btn-bg-info float-end text-white">Update user</button>
                        <a href="{{route('users.index', $account)}}"
                           class="btn btn-outline btn-outline-solid btn-outline-default float-end mx-3">Cancel</a>
                    </div>
                </div>
                </form>


            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove User</h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                         aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to delete this user? {{$user->first_name}} {{$user->last_name}}</p>
                </div>

                <div class="modal-footer">
                    <form action="{{ route('users.destroy', ['account' => $account, 'user' => $user])}}" method="post">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Yes, Delete!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-base-layout>
