<?php

namespace Tests\Feature\Jobs;

use App\Jobs\CopyInstall;
use App\Jobs\CreateInstall;
use App\Jobs\DeleteInstall;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class Kub8JobTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite(true);
    }

    public function test_create_install_job():void
    {
        Http::fake([
            env('KUB8_API').'install/create' => Http::response([], 200),
        ]);

        $job = new CreateInstall($this->install);
        $job->handle();
        Http::assertSent(function (Request $request) {
            return $request->hasHeader('Authorization', 'Basic '.\base64_encode(env('KUB8_USERNAME').':'.env('KUB8_PASSWORD'))) &&
                   $request->url() == env('KUB8_API').'install/create' &&
                   $request->method() == 'POST' &&
                   $request['id'] == $this->install->name &&
                   $request['env_type'] == $this->install->type &&
                   $request['size'] == $this->install->size &&
                   $request['domain'] == $this->install->domain &&
                   $request['region'] == $this->install->region;
        });
    }

    public function test_create_install_job_fail():void
    {
        Http::fake([
            env('KUB8_API').'install/create' => Http::response([
                'status' => 'error',
                'message' =>'statefulsets.apps "recorder3" not found',
            ], 413),
        ]);

        Log::shouldReceive('emergency')
        ->once();

        $job = new CreateInstall($this->install);
        $job->handle();
        Http::assertSent(function (Request $request) {
            return $request->hasHeader('Authorization', 'Basic '.\base64_encode(env('KUB8_USERNAME').':'.env('KUB8_PASSWORD'))) &&
                   $request->url() == env('KUB8_API').'install/create' &&
                   $request->method() == 'POST' &&
                   $request['id'] == $this->install->name &&
                   $request['env_type'] == $this->install->type &&
                   $request['size'] == $this->install->size &&
                   $request['domain'] == $this->install->domain &&
                   $request['region'] == $this->install->region;
        });
    }

    public function test_copy_install_job():void
    {
        Http::fake([
            env('KUB8_API').'install/copy' => Http::response([], 200),
        ]);

        $job = new CopyInstall($this->install);
        $job->handle();
        Http::assertSent(function (Request $request) {
            return $request->hasHeader('Authorization', 'Basic '.\base64_encode(env('KUB8_USERNAME').':'.env('KUB8_PASSWORD'))) &&
                   $request->url() == env('KUB8_API').'install/copy' &&
                   $request->method() == 'POST' &&
                   $request['id'] == $this->install->name &&
                   $request['env_type'] == $this->install->type &&
                   $request['size'] == $this->install->size &&
                   $request['domain'] == $this->install->domain &&
                   $request['region'] == $this->install->region;
        });
    }

    public function test_copy_install_job_fail():void
    {
        Http::fake([
            env('KUB8_API').'install/copy' => Http::response([], 500),
        ]);
        Log::shouldReceive('emergency')
        ->once()
        ->with('Kub8 Request Failed 500 : "[] Orgianl Request: {\"id\":\"domain\",\"env_type\":\"dev\",\"size\":\"s0\",\"domain\":null,\"region\":\"us-east-1\"}"');

        $job = new CopyInstall($this->install);
        $job->handle();
        Http::assertSent(function (Request $request) {
            return $request->hasHeader('Authorization', 'Basic '.\base64_encode(env('KUB8_USERNAME').':'.env('KUB8_PASSWORD'))) &&
                   $request->url() == env('KUB8_API').'install/copy' &&
                   $request->method() == 'POST' &&
                   $request['id'] == $this->install->name &&
                   $request['env_type'] == $this->install->type &&
                   $request['size'] == $this->install->size &&
                   $request['domain'] == $this->install->domain &&
                   $request['region'] == $this->install->region;
        });
    }

    public function test_delete_install_job():void
    {
        Http::fake([
            env('KUB8_API')."install/{$this->install->name}" => Http::response([], 200),
        ]);

        $job = new DeleteInstall($this->install);
        $job->handle();
        Http::assertSent(function (Request $request) {
            return $request->hasHeader('Authorization', 'Basic '.\base64_encode(env('KUB8_USERNAME').':'.env('KUB8_PASSWORD'))) &&
                   $request->url() == env('KUB8_API')."install/{$this->install->name}" &&
                   $request->method() == 'DELETE';
        });
    }

    public function test_delete_install_job_fail():void
    {
        Http::fake([
            env('KUB8_API')."install/{$this->install->name}" => Http::response([], 413),
        ]);
        Log::shouldReceive('emergency')
        ->once()
        ->with('Kub8 Request Failed 413 : "[] Orgianl Request: domain"');

        $job = new DeleteInstall($this->install);
        $job->handle();
        Http::assertSent(function (Request $request) {
            return $request->hasHeader('Authorization', 'Basic '.\base64_encode(env('KUB8_USERNAME').':'.env('KUB8_PASSWORD'))) &&
                   $request->url() == env('KUB8_API')."install/{$this->install->name}" &&
                   $request->method() == 'DELETE';
        });
    }
}
