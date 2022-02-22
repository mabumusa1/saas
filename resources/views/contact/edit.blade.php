<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class="mb-10 col-12 border p-10">
                    <div class="d-flex justify-content-between mb-5">
                        <h1>Techincal Contacts</h1>
                        <div class="separator mb-5"></div>
                    </div>

                    <form method="post">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <div class="mb-10 col-12 border p-10">
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <label class="required">Environment Name</label>
                                    <input name="env_name" type="text" value=""
                                           class="form-control form-control-solid" placeholder=""/>
{{--                                    @if ($errors->has('first_name'))--}}
                                        <span class="help-block"><strong></strong></span>
{{--                                    @endif--}}
                                </div>
                            </div>
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <label class="required">Name</label>
                                    <input name="name" value="" type="text"
                                           class="form-control form-control-solid" placeholder=""/>
{{--                                    @if ($errors->has('last_name'))--}}
                                        <span class="help-block"><strong></strong></span>
{{--                                    @endif--}}
                                </div>
                            </div>
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <label class="required">Email</label>
                                    <input name="email" value="" type="text"
                                           class="form-control form-control-solid" placeholder=""/>
{{--                                    @if ($errors->has('email'))--}}
                                        <span class="help-block"><strong></strong></span>
{{--                                    @endif--}}
                                </div>
                            </div>
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <label class="required">Phone Number</label>
                                    <div class="col-5 position-relative">

                                    <input name="phone" value="" type="number"
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

{{--                                    @if ($errors->has('email'))--}}
                                        <span class="help-block"><strong></strong></span>
{{--                                    @endif--}}
                                </div>
                            </div>
                            <div class="separator mb-5"></div>
                            <div class="my-4 d-flex justify-content-end">
                                <a href="#" class="btn btn-outline btn-outline-solid btn-outline-default mx-3">Back</a>
                                <button href="#" type="submit" class="btn btn-bg-info text-white">Update Contact</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
