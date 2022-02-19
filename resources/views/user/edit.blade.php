<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <div class=" mb-5">
                    <h1>Edit user</h1>
                    <div class="separator mb-5"></div>
                </div>

                <div class="mb-10 col-12 border p-10">
                    <div class="bg-gray-100 rou p-6 my-4">
                        <h1 class="text-black">Bryan Coward</h1>
                        <p>byranccoward@gmail.com</p>
                    </div>
                    <div class="form-group fv-row col-5 my-4">
                        <label class="required text-lg-start">Account access</label>
                        <a href="#" class="float-end">View access type definitions</a>
                        <select class="form-select form-select-solid" aria-label="Select example">
                            <option>Open this select menu</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                    <div class="separator mb-5"></div>
                    <div class="my-4">
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#kt_modal_1">
                            <i class="bi bi-dash-circle fs-4 me-2"></i>Remove user
                        </button>
                        <a href="#" class="btn btn-bg-info float-end text-white">Update user</a>
                        <a href="#" class="btn btn-outline btn-outline-solid btn-outline-default float-end mx-3">Cancel</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Remove User</h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <p>Are you sure you want to delete this user? {username or name}</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">Yes, Delete!</button>
                </div>
            </div>
        </div>
    </div>

</x-base-layout>
