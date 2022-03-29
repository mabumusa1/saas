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
            <form action="{{ route('transfer.start', [$currentAccount->id, $install->id]) }}" method="POST">
                @csrf
                <input type="hidden" name="install_id" value="{{ $install_id }}">
                <div class="modal-body">
                    <div class="form-group mb-10">
                        <label for="email">Email</label>
                        <input name="email" id="email" type="email" class="form-control" />
                    </div>
                    <div class="form-group mb-10">
                        <label for="note">Note</label>
                        <textarea name="note" id="note" cols="30" rows="10" class="form-control"></textarea>
                    </div>
                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>
