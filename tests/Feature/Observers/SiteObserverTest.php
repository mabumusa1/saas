<?php

namespace Tests\Feature\Observers;

use App\Models\Group;
use App\Observers\SiteObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SiteObserverTest extends TestCase
{
    use RefreshDatabase;

    private SiteObserver $observer;

    public function setUp():void
    {
        parent::setUp();
        $this->addSite(true);
        $this->observer = new SiteObserver();
    }

    public function test_site_deleted():void
    {
        Http::fake();
        $group = Group::factory()->for($this->account)->create();
        $this->site->groups()->attach($group);
        $this->site->delete();
        $this->assertSoftDeleted($this->site);
        $this->assertSoftDeleted($this->install);
        $this->assertEquals($this->site->groups()->count(), 0);
    }
}
