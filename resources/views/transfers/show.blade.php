<x-base-layout>
    <form action="{{ route('transfer.accept', [$currentAccount, $transfer]) }}" method="post">
        @csrf
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">{{ __('Accept Transfer') }}</h3>
            </div>
            <div class="card-body">
                <p class="text-center">{{ __('Please choose whether you want to attach the transfer to an existing site or
                    new site') }}</p>
                <div class="text-center">
                    <div class="row text-center d-flex justify-content-center">
                        <div class="col-4">
                            <!--begin::Option-->
                            <input type="radio" class="btn-check" name="transfer_way" value="existing"
                                id="existing" @if(old('transfer_way') == 'existing') checked @endif>
                            <label
                                class="btn btn-outline btn-active-light-primary btn-outline-primary p-7 d-flex justify-content-center align-items-center mb-5"
                                for="existing">
                                <span class="d-block fw-bold text-center">
                                    <span
                                        class="text-dark fw-bolder d-block fs-3">{{ __('Choose existing site') }}</span>
                                </span>
                            </label>
                            <!--end::Option-->
                        </div>
                        <div class="col-4">
                            <!--begin::Option-->
                            <input type="radio" class="btn-check" name="transfer_way" value="new" id="new" @if(old('transfer_way') == 'new') checked @endif/>
                            <label
                                class="btn btn-outline btn-outline-primary btn-active-light-primary p-7 d-flex justify-content-center align-items-center mb-5"
                                for="new">
                                <span class="d-block fw-bold text-center">
                                    <span class="text-dark fw-bold fs-3">
                                        {{ __('Create new site') }}
                                    </span>
                                </span>
                            </label>
                            <!--end::Option-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mt-10 d-none site" id="site_existing">
            <div class="card-header">
                <h3 class="card-title">{{ __('Choose Site') }}</h3>
            </div>
            <div class="card-body">
                <select class="form-select" name="site_id">
                    <option value="" disabled selected>
                        {{ __('Please select an site') }}</option>
                    @foreach ($sites as $site)
                        <option value="{{ $site->id }}">{{ $site->name }}
                        </option>
                    @endforeach
                </select>
                <div class="d-flex justify-content-end mt-10">
                    <button class="btn btn-primary" type="submit">{{ __('Accept Transfer') }}</button>
                </div>
            </div>
        </div>
        <div class="card shadow-sm mt-10 d-none site" id="site_new">
            <div class="card-header">
                <h3 class="card-title">{{ __('Create site') }}</h3>
            </div>
            <div class="card-body">
                <div class="flex-column">
                    <h3 class="text-dark mb-8">{{ __('Who owns the site?') }}</h3>
                    <!-- Start: Site Creation Way -->
                    <div class="mb-5">
                        <h3 class="text-dark mb-8">{{ __('How do you like to start?') }}</h3>
                        <div class="row">
                            <div class="mb-10">
                                <div class="form-group fv-row">
                                    <div class="col">
                                    <label>{{ __('Site Name') }}</label>
                                    </div>
                                    <div class="col">
                                    <input name="site_name" type="text" class="form-control form-control-solid @error('site.name') is-invalid @enderror"
                                        placeholder="{{ __('Site Name') }}" />
                                        @error('site.name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        {{ __('This site is mine; it will count towards my site allowance') }}
                                        <br />
                                        {{ __('You have ') . $subscriptions->sum('quantity') - $subscriptions->sum('sites_count') }}
                                        of {{ $totalActiveSubscriptions }} {{ __('sites available.') }}
                                        @if ($subscriptions->count() === 0)
                                            {{ __('Delete site or ') }} <a class="text-primary"
                                                href="{{ route('billing.index', [$currentAccount]) }}">
                                                {{ __('Upgrade your plan') }}</a>
                                        @endif
        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-10">
                    <button class="btn btn-primary" type="submit">{{ __('Accept Transfer') }}</button>
                </div>
            </div>
        </div>
    </form>

    @push('scripts')
        <script>
            document.querySelectorAll('input[name="transfer_way"]').forEach(function(el) {
                el.addEventListener('input', function(event) {
                    document.querySelectorAll('.site').forEach(function(site) {
                        site.classList.add('d-none');
                    });
                    document.querySelector('#site_' + event.target.value).classList.remove('d-none');
                })
            })
            document.querySelector('input[name="transfer_way"]:checked').dispatchEvent(new Event('input'));
        </script>
    @endpush
</x-base-layout>
