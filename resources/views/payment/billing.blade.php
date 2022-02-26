<x-base-layout>
    <?php
    $subscription = $currentAccount->subscription('Small Installs')->all();
    
     ?>

     @foreach ($subscription as $subscription )
     {{ $subscription->paddleEmail(); }} <br/>

     {{ $subscription->paymentMethod(); }}<br/>
     {{ $subscription->cardBrand(); }}<br/>
     {{ $subscription->cardLastFour(); }} <br/>
     {{ $subscription->cardExpirationDate(); }}<br/>
     <hr/>
     @endforeach
</x-base-layout>