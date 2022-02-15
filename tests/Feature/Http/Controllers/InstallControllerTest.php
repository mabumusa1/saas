<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Install;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InstallController
 */
class InstallControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $installs = Install::factory()->count(3)->create();

        $response = $this->get(route('install.index'));

        $response->assertOk();
        $response->assertViewIs('install.index');
        $response->assertViewHas('installs');
    }

    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('install.create'));

        $response->assertOk();
        $response->assertViewIs('install.create');
    }

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InstallController::class,
            'store',
            \App\Http\Requests\InstallStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $site = Site::factory()->create();
        $name = $this->faker->name;
        $type = $this->faker->randomElement(/* enum_attributes **/);
        $tech_contact_first_name = $this->faker->word;
        $tech_contact_last_name = $this->faker->word;
        $tech_contact_email = $this->faker->word;
        $tech_contact_phone = $this->faker->word;

        $response = $this->post(route('install.store'), [
            'site_id' => $site->id,
            'name' => $name,
            'type' => $type,
            'tech_contact_first_name' => $tech_contact_first_name,
            'tech_contact_last_name' => $tech_contact_last_name,
            'tech_contact_email' => $tech_contact_email,
            'tech_contact_phone' => $tech_contact_phone,
        ]);

        $installs = Install::query()
            ->where('site_id', $site->id)
            ->where('name', $name)
            ->where('type', $type)
            ->where('tech_contact_first_name', $tech_contact_first_name)
            ->where('tech_contact_last_name', $tech_contact_last_name)
            ->where('tech_contact_email', $tech_contact_email)
            ->where('tech_contact_phone', $tech_contact_phone)
            ->get();
        $this->assertCount(1, $installs);
        $install = $installs->first();

        $response->assertRedirect(route('install.index'));
        $response->assertSessionHas('install.id', $install->id);
    }

    /**
     * @test
     */
    public function show_displays_view()
    {
        $install = Install::factory()->create();

        $response = $this->get(route('install.show', $install));

        $response->assertOk();
        $response->assertViewIs('install.show');
        $response->assertViewHas('install');
    }

    /**
     * @test
     */
    public function edit_displays_view()
    {
        $install = Install::factory()->create();

        $response = $this->get(route('install.edit', $install));

        $response->assertOk();
        $response->assertViewIs('install.edit');
        $response->assertViewHas('install');
    }

    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InstallController::class,
            'update',
            \App\Http\Requests\InstallUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $install = Install::factory()->create();
        $site = Site::factory()->create();
        $name = $this->faker->name;
        $type = $this->faker->randomElement(/* enum_attributes **/);
        $tech_contact_first_name = $this->faker->word;
        $tech_contact_last_name = $this->faker->word;
        $tech_contact_email = $this->faker->word;
        $tech_contact_phone = $this->faker->word;

        $response = $this->put(route('install.update', $install), [
            'site_id' => $site->id,
            'name' => $name,
            'type' => $type,
            'tech_contact_first_name' => $tech_contact_first_name,
            'tech_contact_last_name' => $tech_contact_last_name,
            'tech_contact_email' => $tech_contact_email,
            'tech_contact_phone' => $tech_contact_phone,
        ]);

        $install->refresh();

        $response->assertRedirect(route('install.index'));
        $response->assertSessionHas('install.id', $install->id);

        $this->assertEquals($site->id, $install->site_id);
        $this->assertEquals($name, $install->name);
        $this->assertEquals($type, $install->type);
        $this->assertEquals($tech_contact_first_name, $install->tech_contact_first_name);
        $this->assertEquals($tech_contact_last_name, $install->tech_contact_last_name);
        $this->assertEquals($tech_contact_email, $install->tech_contact_email);
        $this->assertEquals($tech_contact_phone, $install->tech_contact_phone);
    }

    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $install = Install::factory()->create();

        $response = $this->delete(route('install.destroy', $install));

        $response->assertRedirect(route('install.index'));

        $this->assertDeleted($install);
    }
}
