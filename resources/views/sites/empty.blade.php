<x-base-layout>
    <div class="d-flex justify-content-center align-items-center">
        <div class="text-center">
            <img class="mb-3"
                src="{{ asset(theme()->getMediaUrlPath() . 'illustrations/unitedpalms-1/2.png') }}" width="200">
            <h1>Welcome, {{ auth()->user()->fullName }}!</h1>
            <p>You have no sites added, lets get started and add one.</p>
        </div>
    </div>
    <div>
        <div class="row justify-content-around">
            <div class="col col-5">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <img width="100" src="{{ asset(theme()->getMediaUrlPath() . 'custom/new-window.png') }}"
                            alt="">
                        <div class="ms-3">
                            <h5 class="card-title mb-5">Add a new site</h5>
                            <p class="mb-0">Need more information?</p>
                            <a href="#">Learn more about adding a site</a>
                            <a href="" class="btn btn-primary btn-sm mt-5 ">Add now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-5">
                <div class="card">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <img width="100" src="{{ asset(theme()->getMediaUrlPath() . 'custom/file-upload.png') }}"
                            alt="">
                        <div class="ms-3">
                            <h5 class="card-title mb-5">Accept a transfer</h5>
                            <p class="mb-0">Waiting on a transfer?</p>
                            <a href="#">Learn more about site transfers</a>
                            <a href="" class="btn btn-primary btn-sm mt-5 ">Accept now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
