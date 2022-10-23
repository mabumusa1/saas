<x-base-layout>
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col text-center">
                    <img class="mb-3" src="{{ asset('skin/media/illustrations/unitedpalms-1/2.png') }}" width="200">
                    <h1 class="mb-3">{{ __('Welcome') }} , {{ auth()->user()->fullName }}!</h1>
                    <h2 class="mb-3">{{ __('You have no sites added, lets get started and add one.') }}</h2>
                    </div>
            </div>
            <div class="row mb-2">
                <div class="col">
                    <div class="card bordered">
                        <div class="card-body text-center">
                            <img width="100" src="{{ asset('skin/media/custom/new-window.png') }}" alt="">
                            <h5 class="card-title mb-5">{{ __('Add a new site') }}</h5>
                            <p class="mb-0"><a href="#">{{ __('Learn more about adding a site') }}</a></p>
                            <a href="{{ route('sites.create', $currentAccount->id) }}" class="btn btn-primary btn-lg mt-5">{{ __('Add now') }}</a>

                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card bordered">
                        <div class="card-body text-center">
                            <img width="100" src="{{ asset('skin/media/custom/file-upload.png') }}" alt="">
                            <h5 class="card-title mb-5">{{ __('Accept a transfer') }}</h5>
                            <p class="mb-0"><a href="#">{{ __('Learn more about site transfers') }}</a></p>
                            <button data-bs-toggle="modal"
                            data-bs-target="#accept_transfer_modal" class="btn btn-primary btn-lg mt-5 ">{{ __('Accept now') }}</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="accept_transfer_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Accept Site Transfer') }}</h5>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-2x">
                            {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                        </span>
                    </div>
                    <!--end::Close-->
                </div>
                <form action="{{ route('transfer.check', [$currentAccount->id]) }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group mb-10">
                            <label for="code">Code</label>
                            <input name="code" id="code" type="text" class="form-control" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Accept') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-base-layout>
