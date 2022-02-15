<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Domain;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DomainController
 */
class DomainControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('domain.create'));

        $response->assertOk();
        $response->assertViewIs('domain.create');
    }

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DomainController::class,
            'store',
            \App\Http\Requests\DomainStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_redirects()
    {
        $name = $this->faker->name;

        $response = $this->post(route('domain.store'), [
            'name' => $name,
        ]);

        $response->assertRedirect(route('site.show', [$site.id]));
        $response->assertSessionHas('domain.id', $domain->id);
    }

    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $domain = Domain::factory()->create();

        $response = $this->delete(route('domain.destroy', $domain));

        $response->assertRedirect(route('site.show', [$site.id]));

        $this->assertDeleted($domain);
    }
}
