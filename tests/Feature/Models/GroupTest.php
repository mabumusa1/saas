<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\Group;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_has_site():void
    {
        $account = Account::factory()->create();
        $group = Group::factory()->create(['account_id' => $account->id]);
        $site = Site::factory()->create(['account_id' => $account->id]);
        $site->groups()->sync([$group->id]);
        $this->assertTrue(true);
    }
}
