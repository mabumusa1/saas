<?php

namespace Tests\Feature\Jobs;

use App\Jobs\VerifyDomain;
use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Site;
use App\Models\Install;
use App\Models\Domain;
use Mockery\MockInterface;
use Spatie\Dns\Dns;
use Spatie\Dns\Records\CNAME;
use Mockery;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;
use App\Exceptions\DomainVerificationFailedException;


class VerifyDomainTest extends TestCase
{
    use RefreshDatabase;

    private $install;

    private $site;

    private $domain;

    private $dnsMock;
    

    public function setUp(): void
    {
        parent::setUp();
        parent::setUpAccount();
        $this->site = Site::factory()->for($this->account)->create();
        $this->install = Install::factory()
        ->for($this->site)
        ->create(['name' => 'domain']);
        $this->domain = Domain::factory()
        ->for($this->install)
        ->create(['name' => 'domain.steercampaign.com', 'primary' => true, 'verified_at' => null]);

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
                'host' => "m.iabaustralia.com.au",
                'ttl' => 3600,
                'class' => "IN",
                'type' => "CNAME",
                'target'=> "domain.steercampaign.com",
            ])
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
                'host' => "m.iabaustralia.com.au",
                'ttl' => 3600,
                'class' => "IN",
                'type' => "CNAME",
                'target'=> "start.steercampaign.com",
            ])
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
