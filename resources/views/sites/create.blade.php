<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-body">
                <h2 class="text-dark mb-8">Get Started</h2>
                <!--begin::Stepper-->
                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="create_stepper">
                    <!--begin::Aside-->
                    <div class="d-flex flex-row-auto w-100 w-lg-300px">
                        <!--begin::Nav-->
                        <div class="stepper-nav flex-cente">
                            <!--begin::Step 1-->
                            <div class="stepper-item me-5 current" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->

                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">1</span>
                                </div>
                                <!--end::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Define your site
                                    </h3>

                                    <div class="stepper-desc">
                                        Setup your site defintion
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 1-->

                            <!--begin::Step 2-->
                            <div class="stepper-item me-5" data-kt-stepper-element="nav">
                                <!--begin::Line-->
                                <div class="stepper-line w-40px"></div>
                                <!--end::Line-->

                                <!--begin::Icon-->
                                <div class="stepper-icon w-40px h-40px">
                                    <i class="stepper-check fas fa-check"></i>
                                    <span class="stepper-number">2</span>
                                </div>
                                <!--begin::Icon-->

                                <!--begin::Label-->
                                <div class="stepper-label">
                                    <h3 class="stepper-title">
                                        Set the settings
                                    </h3>

                                    <div class="stepper-desc">
                                        Configure your site
                                    </div>
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Step 2-->
                        </div>
                        <!--end::Nav-->
                    </div>

                    <!--begin::Content-->
                    <div class="flex-row-fluid">
                        <!--begin::Form-->
                        <form id="site-form" method="post" class="form w-lg-500px mx-auto" novalidate="novalidate">
                            @csrf
                            @method('post')
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!--begin::Group-->
                            <div class="mb-5">
                                <!--begin::Step 1-->
                                <div class="flex-column current" data-kt-stepper-element="content">
                                    <h3 class="text-dark mb-8">Who owns the site?</h3>
                                    <!-- Begin Site Type -->
                                    <div class="mb-10">
                                        <div class="form-check form-check-custom form-check-solid form-check-lg">
                                            <input name="type" class="form-check-input" type="radio" value="mine" id="radioMine" disabled>
                                            <label class="form-check-label" for="radioMine">
                                                This site is mine; it will count towards my site allowance
                                                <br/>
                                                You have 0 of 1 sites available. Delete site or <a href="#">Upgrade your plan</a>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-10">
                                        <div class="form-check form-check-custom form-check-solid form-check-lg">
                                            <input name="type" class="form-check-input" type="radio" value="transferable" id="radioTransferable">
                                            <label class="form-check-label" for="radioTransferable">
                                                This site is transferable; it will be moved to someone else's account.
                                                <br/>
                                                You'll be transferring the site to a client or collaborator
                                            </label>
                                        </div>
                                    </div>
                                    <!-- End Site Type -->
                                    <hr/>
                                    <!-- Start: Site Creation Way -->
                                    <div class="mb-5">
                                        <h3 class="text-dark mb-8">How do you like to start?</h3>
                                        <div class="mb-10">
                                            <div class="form-check form-check-custom form-check-solid form-check-lg">
                                                <input name="start" class="form-check-input" type="radio" value="blank" id="blank">
                                                <label class="form-check-label" for="blank">
                                                    Start with a blank site
                                                    <br/>
                                                    Add an empty Mautic site pre-installed
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-10">
                                            <div class="form-check form-check-custom form-check-solid form-check-lg muted">
                                                <input name="start" class="form-check-input" type="radio" value="copyEnv" id="copyEnv">
                                                <label class="form-check-label" for="copyEnv">
                                                    Copy an existing environment to a new site
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-10">
                                            <div class="form-check form-check-custom form-check-solid form-check-lg muted">
                                                <input name="start" class="form-check-input" type="radio" value="moveEnv" id="moveEnv">
                                                <label class="form-check-label" for="moveEnv">
                                                    Move an existing environment to a new site
                                                </label>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                                <!--begin::Step 1-->

                                <!--begin::Step 2-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    <h3>Site name and first environment</h3>
                                    <p>A site is a group of up to three environments (Production, Staging, Development) under one name</p>
                                    <div class="mb-10">
                                        <div class="form-group has-validation">
                                            <label>Site Name</label>
                                            <input name="sitename" type="text" class="form-control form-control-solid" placeholder="" minlength="1" maxlength="40"/> <!-- need validation -->
                                            <span id="siteerr" class="form-text text-muted">Site name is unique</span>
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>Environment Name</label>
                                                    <input name="environmentname" type="text" class="form-control form-control-solid" placeholder="" minlength="3" maxlength="14"/><span> <!-- need validation -->
                                                    <span id="enverr" class="form-text text-muted">Enviroment name is unique</span>
                                                </div>
                                            </div>
                                            <div class="col d-flex align-items-center">
                                                <p>.steercampaign.com</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <h3>Environment Type</h3>
                                        <p>Create additional environments later from the site overview page</p>
                                    </div>
                                    <div class="mb-10">
                                        <div class="form-check form-check-custom form-check-solid form-check-lg">
                                            <input name="environment" class="form-check-input" type="radio" value="prd" id="radioProduction">
                                            <label class="form-check-label" for="radioProduction">
                                                <strong><span class="badge badge-success">PRD</span> Production (live)</strong><br/>
                                                <p>Host a public site</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <div class="form-check form-check-custom form-check-solid form-check-lg">
                                            <input name="environment" class="form-check-input" type="radio" value="stg" id="radioStaging">
                                            <label class="form-check-label" for="radioStaging">
                                                <strong><span class="badge badge-light-success">STG</span> Staging (optional sandbox)</strong><br/>
                                                <p>Review and test before deploying to Production</p>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mb-10">
                                        <div class="form-check form-check-custom form-check-solid form-check-lg">
                                            <input name="environment" class="form-check-input" type="radio" value="dev" id="radioDev">
                                            <label class="form-check-label" for="radioDev">
                                                <strong><span class="badge badge-light-dark">DEV</span>Development (optional sandbox)</strong><br/>
                                                <p>Build and experiment before deploying to Staging or Production</p>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <!--begin::Step 2-->
                            </div>
                            <!--end::Group-->

                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                        Back
                                    </button>
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Wrapper-->
                                <div>
                                    <button id="btn-submit" type="button" class="btn btn-primary" data-kt-stepper-action="submit">
                                        <span class="indicator-label">
                                            Submit
                                        </span>
                                        <span class="indicator-progress">
                                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>

                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                        Continue
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <!--end::Stepper-->
            </div>
        </div>
    </div>

@section('scripts')
<script>
var element = document.querySelector("#create_stepper");
// Initialize Stepper
var stepper = new KTStepper(element);

// Handle next step
stepper.on("kt.stepper.next", function (stepper) {
    stepper.goNext(); // go next step
});

// Handle previous step
stepper.on("kt.stepper.previous", function (stepper) {
    stepper.goPrevious(); // go previous step
});

$(document).ready(function() {
    $('#btn-submit').click(function (e) {

        $('#btn-submit').attr("data-kt-indicator","on");
        e.preventDefault();

        var _token = $("input[name='_token']").val();
        var type = $("input[name='type']:checked").val();
        var start = $("input[name='start']:checked").val();
        var sitename = $("input[name='sitename']").val();
        var environmentname = $("input[name='environmentname']").val();
        var environment = $("input[name='environment']").val();

        axios.post('/form-validation', {
                type: type,
                start: start,
                sitename: sitename,
                environmentname: environmentname,
                environment: environment
            },
            {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': _token,
                    'X-Requested-With': 'XMLHttpRequest',
                }
            }).then(function(response){
                $('#btn-submit').attr("data-kt-indicator","off");
        }).catch(function(error){
            $('#btn-submit').attr("data-kt-indicator","off")
            console.log(error.response.data.errors)
            var err = error.response.data.errors;
            if('sitename' in err){
                $('#siteerr').addClass('text-danger');
                $('#siteerr').removeClass('text-muted');
                $('#siteerr').text(err['sitename']);
            }if('environmentname' in err){
                $('#enverr').addClass('text-danger');
                $('#enverr').removeClass('text-muted');
                $('#enverr').text(err['environmentname']);
            }

        })
    });
});
</script>
@endsection
</x-base-layout>
