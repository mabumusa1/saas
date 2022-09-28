<x-base-layout>
    <div class="container mb-8">
        <div class="card overlay">
            <div class="card-body">
                @if($currentAccount->availableSubscriptions === 0 && $currentAccount->availableQuota === 0)
                <div class="card card-bordered mb-5">
                    <div class="card-header bg-secondary">
                        <h3 class="card-title">{{ __('You do not have enough subscriptions') }}</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="alert alert-danger">
                        <h3 class="mb-5">{{ __('You need to add more subscriptions to your account to add new sites') }}</h3>
                            <a class="btn btn-primary" href="{{ route('billing.index', [$currentAccount]) }}">{{ __('Add Subscription') }}</a>                            
                        </div>
                    </div>
                </div>
                @else
                <!--begin::Form-->
                <form method="post" action="{{ route('sites.store', $currentAccount->id) }}" id="site-form"
                    class="form mx-auto" novalidate autocomplete="off">
                    @csrf
                    @if ($errors->any())
                    <div class="mb-5">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="mb-5">
                        @include('sites._partials._step1')
                        @include('sites._partials._step2')
                        @include('sites._partials._step3')
                        
                    </div>
                    <div class="card-footer text-end">
                        <button type="submit" name="submitButton" class="btn btn-success btn-lg">
                                {{ __('Add site') }}
                        </button>
                    </div>
                </form>
                <!--end::Form-->                
                @endif
            </div>
        </div>
    </div>
@include('sites._partials._scripts')  
</x-base-layout>