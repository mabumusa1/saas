<?php

namespace App\Listeners;

use App\Models\Cashier\Subscription;
use Laravel\Cashier\Events\WebhookReceived;
use Log;

class StripeEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  WebhookReceived  $event
     * @return void
     */
    public function handle(WebhookReceived $event)
    {
        if ($event->payload['type'] === 'customer.subscription.deleted') {
            $subscription = Subscription::where('stripe_id', $event->payload['data']['object']['id'])->first();
            $subscription->sites()->delete();
        }
    }
}
