<?php

namespace Tests\Feature\Jobs;

use App\Exceptions\DomainVerificationFailedException;
use App\Jobs\VerifyDomain;
use App\Models\Account;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use Mockery;
use Mockery\MockInterface;
use Spatie\Dns\Dns;
use Spatie\Dns\Records\CNAME;
use Tests\TestCase;

class VerifyDomainTest extends TestCase
{
    use RefreshDatabase;

    private $dnsMock;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite(true);

        $this->dnsMock = Mockery::mock('overload:Spatie\Dns\Dns');
        $this->dnsMock = $this->dnsMock->shouldReceive('useNameserver')
        ->once()
        ->andReturnSelf();
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_domain_verified()
    {
        $dnsResponse = [
            new CNAME([
                'host' => 'm.iabaustralia.com.au',
                'ttl' => 3600,
                'class' => 'IN',
                'type' => 'CNAME',
                'target'=> 'domain.'.env('CNAME_DOMAIN'),
            ]),
        ];

        $this->dnsMock->shouldReceive('getRecords')
        ->once()
        ->withArgs([$this->domain->name, 'CNAME'])
        ->andReturn($dnsResponse);

        VerifyDomain::dispatch($this->domain);

        $after = $this->domain->refresh();

        $this->assertNotNull($this->domain->verified_at);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function test_domain_fail_to_verify()
    {
        Bus::fake();
        $dnsResponse = [
            new CNAME([
                'host' => 'm.iabaustralia.com.au',
                'ttl' => 3600,
                'class' => 'IN',
                'type' => 'CNAME',
                'target'=> 'start.'.env('CNAME_DOMAIN'),
            ]),
        ];

        $this->dnsMock->shouldReceive('getRecords')
        ->once()
        ->withArgs([$this->domain->name, 'CNAME'])
        ->andReturn($dnsResponse);

        VerifyDomain::dispatch($this->domain);
        $domain = $this->domain;

        Bus::assertDispatched(function (VerifyDomain $job) use ($domain) {
            $job->failed(new DomainVerificationFailedException());

            return $job->domain->id === $domain->id;
        });

        $after = $this->domain->refresh();
        $this->assertTrue($after->verification_failed);
    }
}
