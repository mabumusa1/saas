<?php

namespace Tests;

use App\Models\Account;
use App\Models\Backup;
use App\Models\Cashier\Subscription;
use App\Models\Contact;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Plan;
use App\Models\Site;
use App\Models\User;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected User $user;

    protected Account $account;

    protected Site $site;

    protected Install $install;

    protected Contact $contact;

    protected Domain $domain;

    protected Backup $backup;

    public function setUp():void
    {
        parent::setUp();
    }

    public function addAccount()
    {
        $this->user = User::factory()->create();
        $this->account = Account::factory()->create();
        $this->account->users()->sync([$this->user->id => ['role' => 'owner']]);
        $this->actingAs($this->user);
    }

    public function addSite($addDomain = false)
    {
        if (empty($this->account)) {
            $this->addAccount();
        }
        $this->site = Site::factory()->for($this->account)->create();
        $this->install = Install::factory()->for($this->site)->create(['name' => 'domain']);
        $this->contact = Contact::factory()->for($this->install)->create();

        if ($addDomain) {
            $this->domain = Domain::factory()
            ->for($this->install)
            ->create(['name' => 'domain.steercampaign.com', 'primary' => true, 'verified_at' => null]);
        }
    }

    public function addBackup()
    {
        if (empty($this->install)) {
            $this->addSite();
        }

        $this->backup = Backup::factory()
        ->for($this->install)
        ->create();
    }

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        if (! static::runningInSail()) {
            static::startChromeDriver();
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments(collect([
            '--window-size=1920,1080',
        ])->unless($this->hasHeadlessDisabled(), function ($items) {
            return $items->merge([
                '--disable-gpu',
                '--headless',
            ]);
        })->all());

        return RemoteWebDriver::create(
            env('DUSK_DRIVER_URL') ?? 'http://selenium-hub:4444/wd/hub',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY,
                $options
            )
        );
    }

    /**
     * Determine whether the Dusk command has disabled headless mode.
     *
     * @return bool
     */
    protected function hasHeadlessDisabled()
    {
        return isset($_SERVER['DUSK_HEADLESS_DISABLED']) ||
               isset($_ENV['DUSK_HEADLESS_DISABLED']);
    }
}
