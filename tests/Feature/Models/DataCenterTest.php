<?php

namespace Tests\Feature\Models;

use App\Models\Account;
use App\Models\DataCenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DataCenterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * check account with datacenter.
     *
     * @return void
     */
    public function test_datacenter_accounts():void
    {
        $dataCenter = new DataCenter();
        $dataCenter->label = 'Test';
        $dataCenter->region = 'Test';
        $dataCenter->save();
        $account = Account::factory()->create(['data_center_id' => $dataCenter->id]);
        $this->assertEquals($dataCenter->accounts()->first()->id, $account->id);
    }
}
