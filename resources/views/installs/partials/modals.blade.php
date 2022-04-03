<!-- Site::TransferModal -->
<div class="modal fade" tabindex="-1" id="transfer_site_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transfer Site</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                    </span>
                </div>
                <!--end::Close-->
            </div>
            <form action="{{ route('transfer.start', [$currentAccount->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="install_id" value="{{ $install_id }}">
                <div class="modal-body">
                    <div class="form-group mb-10">
                        <label for="email">{{ __('Email') }}</label>
                        <input name="email" id="email" type="email" class="form-control" />
                    </div>
                    <div class="form-group mb-10">
                        <label for="note">{{ __('Note') }}</label>
                        <textarea name="note" id="note" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">__('Transfer')</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Site::CopyModal -->
<div class="modal fade" tabindex="-1" id="copy_install_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Copy Install') }}</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                    </span>
                </div>
                <!--end::Close-->
            </div>
            <form action="{{ route('installs.copy', [$currentAccount->id, $site->id, $install->id]) }}">
                @method('PUT')
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning">All data and files in the destination install will be erased</div>
                    <div class="form-group mb-10">
                        <label for="destination">Destination</label>
                        <select name="destination" id="destination" class="form-control">
                            @foreach ($installs as $install)
                                <option value="{{ $install->id }}">{{ $install->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-10">
                        <label for="email">Email</label>
                        <input name="email" id="email" type="email" class="form-control"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Start Copy</button>
                </div>
            </form>
        </div>
    </div>
</div>
