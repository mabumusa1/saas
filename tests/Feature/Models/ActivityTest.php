<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_activity_account()
    {
        $account = Account::factory()->create();
        $activity = Activity::factory()->create(['account_id' => $account->id]);
        $this->assertEquals($account->id, $activity->account->id);
    }
}
