<x-base-layout>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8 mb-4">
                  <div class="card mb-4">
                    <div class="card-header py-3">
                      <h5 class="mb-0">Biling details</h5>
                    </div>
                    <div class="card-body">
                      <form>
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                          <input type="text" id="form7Example3" class="form-control" value="{{ $currentAccount->name }}" />
                          <label class="form-label" for="form7Example3">Billing name</label>
                        </div>
              
                        <!-- Email input -->
                        <div class="form-outline mb-4">
                          <input type="email" id="form7Example5" class="form-control" value="{{ $currentAccount->email }}" />
                          <label class="form-label" for="form7Example5">Billing Email</label>
                        </div>
              
                        <!-- Number input -->
                        <div class="form-outline mb-4">
                          <input type="number" id="form7Example6" class="form-control" />
                          <label class="form-label" for="form7Example6">Phone</label>
                        </div>
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form7Example3" class="form-control" />
                            <label class="form-label" for="form7Example3">Line 1</label>
                          </div>

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form7Example3" class="form-control" />
                            <label class="form-label" for="form7Example3">Line 2</label>
                          </div>
                          

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form7Example3" class="form-control" />
                            <label class="form-label" for="form7Example3">City</label>
                          </div>
                

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form7Example3" class="form-control" />
                            <label class="form-label" for="form7Example3">State</label>
                          </div>
                

                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form7Example3" class="form-control" />
                            <label class="form-label" for="form7Example3">Country</label>
                          </div>
                        <!-- Text input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form7Example3" class="form-control" />
                            <label class="form-label" for="form7Example3">Postal Code</label>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg btn-block">
                            Make purchase
                          </button>
    
                      </form>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>

</x-base-layout>