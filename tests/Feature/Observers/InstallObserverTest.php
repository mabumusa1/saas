<?php

namespace Tests\Feature\Observers;

use App\Observers\InstallObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
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
    }

    public function test_install_created():void
    {
        Http::fake([
            env('KUB8_API')."install/{$this->install->name}" => Http::response([], 200),
        ]);

        $this->observer->created($this->install);

        Http::assertSent(function (Request $request) {
            return $request->hasHeader('X-API-Key', env('KUB8_API_KEY')) &&
                   $request->url() == env('KUB8_API')."install/{$this->install->name}" &&
                   $request->method() == 'POST' &&
                   $request['env_type'] == $this->install->type &&
                   $request['size'] == $this->install->size &&
                   $request['domain'] == $this->install->domain &&
                   $request['region'] == $this->install->region;
        });
    }

    public function test_install_deleted():void
    {
        Http::fake([
            env('KUB8_API')."install/{$this->install->name}" => Http::response([], 200),
        ]);

        $this->observer->deleted($this->install);

        Http::assertSent(function (Request $request) {
            return $request->hasHeader('X-API-Key', env('KUB8_API_KEY')) &&
                   $request->url() == env('KUB8_API')."install/{$this->install->name}" &&
                   $request->method() == 'DELETE';
        });
    }

    public function test_install_copied():void
    {
        Http::fake([
            env('KUB8_API')."install/{$this->install->name}/copy" => Http::response([], 200),
        ]);

        $this->observer->copied($this->install);

        Http::assertSent(function (Request $request) {
            return $request->hasHeader('X-API-Key', env('KUB8_API_KEY')) &&
                   $request->url() == env('KUB8_API')."install/{$this->install->name}/copy" &&
                   $request->method() == 'POST' &&
                   $request['env_type'] == $this->install->type &&
                   $request['size'] == $this->install->size &&
                   $request['domain'] == $this->install->domain &&
                   $request['region'] == $this->install->region;
        });
    }
}
