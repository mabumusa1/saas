<div class="modal fade" tabindex="-1" id="redirectModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gray-200">
                <h5 class="modal-title">{{ __('Add a redirect') }}</h5>
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                    aria-label="Close">
                    <span class="svg-icon svg-icon-2x">
                        {!! get_svg_icon('skin/media/icons/duotone/General/Times.svg') !!}
                    </span>
                </div>
                <!--end::Close-->
            </div>
            <form method="POST" action=""" id="redirect-form" class="form" novalidate="novalidate" autocomplete="off">
                @csrf
                <input type="hidden" id="sourceId" name="sourceIdField">

                <div class="modal-body">
                    <div class="mb-10">
                        <div class="form-group fv-row">
                            <label for="source">{{ __('Domain Name') }}</label>
                            <input id="source" type="text" class="form-control source" readonly />
                        </div>
                    </div>
                    <div class="mb-10">
                        <div class="form-group fv-row">
                            <label for="dest">{{ __('Redirect to') }}</label>
                            <select name="dest" id="dest" class="form-control dest">
                                <option value="null">{{ __('No redirect') }}</option>
                                @foreach($install->domains as $domain)
                                <option value="{{$domain->id}}">{{ $domain->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btn-submit" class="btn btn-primary">{{ __('Add redirect') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>