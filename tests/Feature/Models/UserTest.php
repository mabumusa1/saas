<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_user_role():void
    {
        $account = Account::factory()->create();
        $user = User::factory()->create();
        $account->users()->sync([$user->id => ['role' => 'pb']]);
        $this->assertEquals($user->role($account), 'pb');
    }
}
