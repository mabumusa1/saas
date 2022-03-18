<!-- User::AddModel -->
<div class="modal fade" tabindex="-1" id="add_user_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                    </span>
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
<!-- User::EditModel -->
<div class="modal fade" tabindex="-1" id="edit_user_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update User</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                    </span>
                </div>
                <!--end::Close-->
            </div>
            <form action="" method="POST" id="edit_form">
                @csrf
                @method('PUT')
                <div class="modal-body">
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
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
