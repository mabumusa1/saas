<?php

namespace Tests\Feature\Observers;

use App\Jobs\CopyInstall;
use App\Jobs\CreateInstall;
use App\Jobs\DeleteInstall;
use App\Observers\InstallObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class InstallObserverTest extends TestCase
{
    use RefreshDatabase;

    private InstallObserver $observer;

    public function setUp():void
    {
        parent::setUp();
        $this->addSite(true);
        $this->observer = new InstallObserver();
        Bus::fake();
    }

    public function test_install_created():void
    {
        $this->observer->created($this->install);
        $install = $this->install;
        Bus::assertDispatched(function (CreateInstall $job) use ($install) {
            return $job->install->id === $install->id;
        });
    }

    public function test_install_deleted():void
    {
        $this->observer->deleted($this->install);
        $install = $this->install;
        Bus::assertDispatched(function (DeleteInstall $job) use ($install) {
            return $job->install->id === $install->id;
        });
    }

    public function test_install_copied():void
    {
        $this->observer->copied($this->install);
        $install = $this->install;
        Bus::assertDispatched(function (CopyInstall $job) use ($install) {
            return $job->install->id === $install->id;
        });
    }
}
