<x-base-layout>
    <div class="container mb-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{ __('Dashboard') }}</div>
            </div>
            <div class="card-body">
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border border-gray-300">
                            <div class="card-header bg-gray-200">
                                <div class="card-title">{{ __('Account Summary') }}</div>
                            </div>
                            <div class="card-body py-5 fs-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p>{{ __('Account ID') }}</p> 
                                                    <p class="text-muted">{{ __('Please use it when contacting support') }}</p>
                                                </td>
                                                <td>{{ $currentAccount->id }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>{{ __('Available Subscriptions') }}</p>
                                                    <p class="text-muted">{{ __('# of subscriptions you purchased') }}</p>
                                                </td>
                                                {{-- {{ $currentAccount->sites->count() }} --}}<td>Insert Number of subscriptions</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <p>{{ __('Available Transferable Sites') }}</p>
                                                    <p class="text-muted">{{ __('# of sites you can transfer') }}</p>
                                                    {{--  
                                                    @if($currentAccount->sites->count() === 0)
                                                    <a href="{{ route('billing.manageSubscriptions', $currentAccount) }}">{{ __('Purchase at least one subscription and get unlimited free transfers') }}</a>
                                                    @endif
                                                       
                                                    --}}
                                                </td>
                                                <td>                                                    
                                                    {{ $currentAccount->quota }}                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>                                
                            </div>
                        </div>    
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="card border border-gray-300 h-100">
                            <div class="card-header bg-gray-200">
                                <div class="card-title">{{ __('Steer Campaign Academy') }}</div>
                            </div>
                            <div class="card-body py-5 fs-6">
                                <p>{{ __('We know that building a marketing automation strategy is a tedious job, we are building an academy to help you master Mautic') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card border border-gray-300 h-100">
                            <div class="card-header bg-gray-200">
                                <div class="card-title">{{ __('Steer Campaign Partners Program') }}</div>
                            </div>
                            <div class="card-body py-5 fs-6">
                                <p>{{ __('We want to enable markters to have more opportunity, so we will be lunching a partners program that allows markters to utilize Steer Campaign in more ways available') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="card border border-gray-300 h-100">
                            <div class="card-header bg-gray-200">
                                <div class="card-title">{{ __('Steer Campaign Marketplace') }}</div>
                            </div>
                            <div class="card-body py-5 fs-6">
                                <p>{{ __('We are building a marketplace with many new plugins, themes, and automation that can be used by Steer Campaign clients') }}</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-base-layout>
