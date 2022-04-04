<?php

namespace Tests\Feature\Controllers;

use App\Events\InstallCopyEvent;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class InstallControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::setUpAccount();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_displays_view()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create();
        $contact = Contact::factory()->create([
            'install_id' => $install->id,
        ]);
        $this->get(route('installs.show', ['account' => $this->account, 'site' => $site, 'install' => $install]))
            ->assertOk()
            ->assertViewIs('installs.show');
    }

    public function test_create_all_types_used()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->count(3)
        ->for($site)
        ->state(new Sequence(
            ['type' => 'prd'],
            ['type' => 'stg'],
            ['type' => 'dev']
        ))
        ->create();

        $response = $this->get(route('installs.create', ['account' => $this->account, 'site' => $site, 'install' => $install]));
        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    public function test_create_displays_view_specific_env()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create(['type' => 'stg']);
        $this->get(route('installs.create', ['account' => $this->account, 'site' => $site, 'env' => 'dev']))
            ->assertOk()
            ->assertViewIs('installs.create')
            ->assertViewHas('selectedEnv', 'dev');
    }

    public function test_create_displays_view()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create();
        $this->get(route('installs.create', ['account' => $this->account, 'site' => $site]))
            ->assertOk()
            ->assertViewIs('installs.create');
    }

    public function test_store_fails_if_type_is_wrong()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $site]), [
            'type' => 'dev',
        ]);
        $response->assertSessionHasErrors('type');
    }

    public function test_store_fails_if_wrong_url()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $site]), [
            'type' => 'dev',
            'name' => '[]',
        ]);
        $response->assertSessionHasErrors('name');
    }

    public function test_store_validation()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $site]), [
            'name' => 'test',
            'isValidation' => true,
        ]);
        $response->assertJson(['valid' => true]);
    }

    public function test_store_same_type()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $site]), [
            'name' => 'test',
            'type' => 'dev',
        ]);
        $response->assertSessionHasErrors(['type']);
    }

    public function test_store_success()
    {
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $response = $this->post(route('installs.store', ['account' => $this->account, 'site' => $site]), [
            'name' => 'test',
            'type' => 'prd',
        ]);
        $response->assertSessionHasNoErrors();
    }

    public function test_copy_success()
    {
        Event::fake();
        $site = Site::factory()->create([
            'account_id' => $this->account->id,
        ]);
        $install = Install::factory()
        ->for($site)
        ->create([
            'type' => 'dev',
        ]);
        $dest = Install::factory()
        ->for($site)
        ->create([
            'type' => 'prd',
        ]);

        $response = $this->put(route('installs.copy', ['account' => $this->account, 'site' => $site, 'install' => $install]), [
            'destination' => $dest->id,

        ]);

        Event::assertDispatched(InstallCopyEvent::class);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
}
