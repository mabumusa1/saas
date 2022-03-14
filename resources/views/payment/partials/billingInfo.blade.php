<div class="card card-bordered">
    <div class="card-body">
        <div class="card shadow-sm">
        <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse" data-bs-target="#billing_info">
            <h3 class="card-title">{{ __('Billing Information') }}</h3>
            <div class="card-toolbar rotate-180">
                {!! get_svg_icon("icons/duotune/arrows/arr066.svg") !!}
            </div>
        </div>
        <div id="billing_info" class="collapse hide">
            <div class="card-body">
                <form>
                    <div class="row">
                    <div class="col">
                        <div class="mb-10">
                        <label for="billig_name_txt" class="required form-label">{{ __('Billing Name') }}</label>
                        <input id="billig_name_txt" type="text" class="form-control form-control-solid" placeholder="{{ $currentAccount->name }}" value="{{ $currentAccount->name }}"/>
                        </div>                  
                    </div>
                    <div class="col">
                        <div class="mb-10">
                        <label for="billig_email_txt" class="required form-label">{{ __('Billing Email') }}</label>
                        <input id="billig_email_txt" type="email" class="form-control form-control-solid" placeholder="{{ $currentAccount->email }}" value="{{ $currentAccount->email }}"/>
                        
                        </div>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('Update Billing Information') }}</button>
                </form>
            </div>
        </div>
        </div>      
    </div>
</div>