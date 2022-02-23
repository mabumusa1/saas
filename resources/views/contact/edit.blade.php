<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-10 col-12 border p-10">
                    <div class="d-flex justify-content-between mb-5">
                        <h1>Techincal Contacts</h1>
                        <div class="separator mb-5"></div>
                    </div>
                    <form action="{{ route('contacts.update',['account' => $account, 'contact' => $contact]) }}" method="post">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <div class="mb-10 col-12 border p-10">
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <label>Environment Name</label>
                                    <h3 class="text-dark mb-8">
                                        Devon
{{--                                        {{ $contact->Install }}--}}
{{--                                        @switch($contact->install()->type)--}}
{{--                                            @case('prd')--}}
                                        <span class="badge badge-success">PRD</span>
{{--                                            @break--}}
{{--                                            @case('stg')--}}
{{--                                            <span class="badge badge-light-success">STG</span>--}}
{{--                                            @break--}}
{{--                                            @case('dev')--}}
{{--                                            <span class="badge badge-light-dark">DEV</span>--}}
{{--                                            @break--}}
{{--                                        @endswitch--}}
                                    </h3>

                                </div>
                            </div>
                            <div class="mb-10 row">
                                <div class="form-group col-6 fv-row">
                                    <label class="required">First Name</label>
                                    <input name="first_name" value="{{ $contact->first_name }}" type="text"
                                           class="form-control form-control-solid" placeholder=""/>
                                    @if ($errors->has('first_name'))
                                        <span class="help-block"><strong>{{ $errors->first('first_name') }}</strong></span>
                                    @endif
                                </div>
                                <div class="form-group col-6 fv-row">
                                    <label class="required">Last Name</label>
                                    <input name="last_name" value="{{ $contact->last_name }}" type="text"
                                           class="form-control form-control-solid" placeholder=""/>
                                    @if ($errors->has('last_name'))
                                        <span class="help-block"><strong>{{ $errors->first('last_name') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <label class="required">Email</label>
                                    <input name="email" value="{{ $contact->email }}" type="text"
                                           class="form-control form-control-solid" placeholder=""/>
                                    @if ($errors->has('email'))
                                        <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <label>Phone Number</label>
                                    <div class="col-5 position-relative">

                                    <input name="phone" value="{{ $contact->phone }}" type="tel"
                                           class="form-control form-control-solid" placeholder=""/>
                                    <div class="position-absolute translate-middle-y top-50 end-0 me-3">
                                        <!--begin::Svg Icon | path: icons/duotune/finance/fin002.svg-->
                                        <span class="svg-icon svg-icon-2hx ">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="#a6a6a6">
                                              <path fill-rule="evenodd" d="M7 2a2 2 0 00-2 2v12a2 2 0 002 2h6a2 2 0 002-2V4a2 2 0 00-2-2H7zm3 14a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="separator mb-5"></div>
                            <div class="my-4 d-flex justify-content-end">
                                <a href="{{ route('contacts.index',['account' => $account, 'contact' => $contact]) }}" class="btn btn-outline btn-outline-solid btn-outline-default mx-3">Back</a>
                                <button href="#" type="submit" class="btn btn-bg-info text-white">Update Contact</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
