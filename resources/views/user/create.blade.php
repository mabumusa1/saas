<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class=" mb-5">
                    <h1>Add user</h1>
                    <div class="separator mb-5"></div>
                </div>


                <div class="mb-10 col-12 border p-10">
                    <div class="col-5">
                        <div class="mb-10">
                            <div class="form-group fv-row">
                                <label class="required">First Name</label>
                                <input name="sitename" type="text" class="form-control form-control-solid" placeholder=""/>
                            </div>
                        </div>
                        <div class="mb-10">
                            <div class="form-group fv-row">
                                <label class="required">Last Name</label>
                                <input name="sitename" type="text" class="form-control form-control-solid" placeholder=""/>
                            </div>
                        </div>
                        <div class="mb-10">
                            <div class="form-group fv-row">
                                <label class="required">Email</label>
                                <input name="sitename" type="text" class="form-control form-control-solid" placeholder=""/>
                            </div>
                        </div>
                        <div class="form-group fv-row my-4">
                            <label class="required text-lg-start">Account access</label>
                            <a href="#" class="float-end">View access type definitions</a>
                            <select class="form-select form-select-solid" aria-label="Select example">
                                <option>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>



                    <div class="separator mb-5"></div>
                    <div class="my-4 d-flex justify-content-end">
                        <a href="#" class="btn btn-outline btn-outline-solid btn-outline-default mx-3">Cancel</a>
                        <a href="#" class="btn btn-bg-info text-white">Create user</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

</x-base-layout>
