<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class=" mb-5">
                    <h1>{{ __('Add user') }}</h1>
                    <div class="separator mb-5"></div>
                </div>
                <form method="POST" id ="form_lang_tab" action="{{ route('users.store', $account) }}">
                    @csrf
                    <div class="mb-10 col-12 border p-10">
                    <div class="col-5">
                        <div class="mb-10">
                            <div class="form-group fv-row">
                                <label class="required">{{ __('First Name') }}</label>
                                <input name="first_name" type="text" class="form-control form-control-solid" placeholder="{{ __('First Name') }}" value="{{ old('first_name') }}"/>
                                @if ($errors->has('first_name'))
                                    <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-10">
                            <div class="form-group fv-row">
                                <label class="required">{{ __('Last Name') }}</label>
                                <input name="last_name" type="text" class="form-control form-control-solid" placeholder="{{ __('Last Name') }}"  value="{{ old('last_name') }}"/>
                                @if ($errors->has('last_name'))
                                    <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-10">
                            <div class="form-group fv-row">
                                <label class="required">{{ __('Email') }}</label>
                                <input name="email" type="text" class="form-control form-control-solid" placeholder="{{ __('Email') }}"  value="{{ old('email') }}"/>
                                @if ($errors->has('email'))
                                    <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group fv-row my-4">
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
                    <div class="separator mb-5"></div>
                    <div class="my-4 d-flex justify-content-end">
                        <a href="{{route('users.index', $account)}}" class="btn btn-outline btn-outline-solid btn-outline-default mx-3">{{ __('Cancel') }}</a>
                        <button href="#" type="submit" class="btn btn-bg-info text-white">{{ __('Create user') }}</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

</x-base-layout>
