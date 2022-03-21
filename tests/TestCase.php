<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function mockStripe()
    {
        $this->mock(Stripe::class, function ($mock) {
            $mock->shouldReceive('setApiKey');
        });

        $this->mock(Customer::class, function ($mock) {
            $mock->shouldReceive('create')->andReturn([
                'id' => 'test_stripe_customer_id',
            ]);
        });
    }
}
