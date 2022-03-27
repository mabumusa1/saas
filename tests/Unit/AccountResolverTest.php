<?php

namespace Tests\Unit;

use App\Facades\AccountResolver;
use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountResolverTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_resolve()
    {
        // AccountResolver::spy();

        $account = new Account([
            'name' => 'Test Account',
            'data_center_id' => 1,
            'email' => 'account@a.com',
        ]);

        $this->assertTrue(AccountResolver::resolve($account)->is($account));
    }
}
