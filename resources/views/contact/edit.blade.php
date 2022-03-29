<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-10 col-12 border p-10">
                    <div class="d-flex justify-content-between mb-5">
                        <h1>{{ __('Technical Contacts') }}</h1>
                        <div class="separator mb-5"></div>
                    </div>
                    <form action="{{ route('contacts.update',['account' => $account, 'contact' => $contact]) }}" method="post">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <div class="mb-10 col-12 border p-10">
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <label>{{ __('Install Name') }}</label>
                                    <h3 class="text-dark mb-8">
                                        {{ $contact->install->name }}
                                        @switch($contact->install->type)
                                            @case('prd')
                                                <span class="badge badge-success">{{ __('PRD') }}</span>
                                            @break
                                            @case('stg')
                                            <span class="badge badge-light-success">{{ __('STG') }}</span>
                                            @break
                                            @case('dev')
                                            <span class="badge badge-light-dark">{{ __('DEV') }}</span>
                                            @break
                                        @endswitch
                                    </h3>

                                </div>
                            </div>
                            <div class="mb-10 row">
                                <div class="form-group col-6 fv-row">
                                    <label class="required">{{ __('First Name') }}</label>
                                    <input name="first_name" value="{{ $contact->first_name }}" type="text"
                                           class="form-control form-control-solid" placeholder="{{ __('First Name') }}"/>
                                    @if ($errors->has('first_name'))
                                        <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group col-6 fv-row">
                                    <label class="required">{{ __('Last Name') }}</label>
                                    <input name="last_name" value="{{ $contact->last_name }}" type="text"
                                           class="form-control form-control-solid" placeholder="{{ __('Last Name') }}"/>
                                    @if ($errors->has('last_name'))
                                        <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <label class="required">{{ __('Email') }}</label>
                                    <input name="email" value="{{ $contact->email }}" type="text"
                                           class="form-control form-control-solid" placeholder="{{ __('Email') }}"/>
                                    @if ($errors->has('email'))
                                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <label>{{ __('Phone Number') }}</label>
                                    <div class="col-5 position-relative">

                                    <input name="phone" value="{{ $contact->phone }}" type="tel"
                                           class="form-control form-control-solid" placeholder="{{ __('Phone Number') }}"/>
                                    </div>
                                </div>
                            </div>
                            <div class="separator mb-5"></div>
                            <div class="my-4 d-flex justify-content-end">
                                <a href="{{ route('contacts.index',['account' => $account, 'contact' => $contact]) }}" class="btn btn-outline btn-outline-solid btn-outline-default mx-3">Back</a>
                                <button href="#" type="submit" class="btn btn-bg-info text-white">{{ __('Update Contact') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
