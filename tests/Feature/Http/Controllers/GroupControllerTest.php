<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GroupController
 */
class GroupControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $groups = Group::factory()->count(3)->create();

        $response = $this->get(route('group.index'));

        $response->assertOk();
        $response->assertViewIs('group.index');
        $response->assertViewHas('groups');
    }

    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('group.create'));

        $response->assertOk();
        $response->assertViewIs('group.create');
    }

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupController::class,
            'store',
            \App\Http\Requests\GroupStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $name = $this->faker->name;
        $note = $this->faker->word;

        $response = $this->post(route('group.store'), [
            'name' => $name,
            'note' => $note,
        ]);

        $groups = Group::query()
            ->where('name', $name)
            ->where('note', $note)
            ->get();
        $this->assertCount(1, $groups);
        $group = $groups->first();

        $response->assertRedirect(route('group.index'));
        $response->assertSessionHas('group.id', $group->id);
    }

    /**
     * @test
     */
    public function show_displays_view()
    {
        $group = Group::factory()->create();

        $response = $this->get(route('group.show', $group));

        $response->assertOk();
        $response->assertViewIs('group.show');
        $response->assertViewHas('group');
    }

    /**
     * @test
     */
    public function edit_displays_view()
    {
        $group = Group::factory()->create();

        $response = $this->get(route('group.edit', $group));

        $response->assertOk();
        $response->assertViewIs('group.edit');
        $response->assertViewHas('group');
    }

    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupController::class,
            'update',
            \App\Http\Requests\GroupUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $group = Group::factory()->create();
        $name = $this->faker->name;
        $note = $this->faker->word;

        $response = $this->put(route('group.update', $group), [
            'name' => $name,
            'note' => $note,
        ]);

        $group->refresh();

        $response->assertRedirect(route('group.index'));
        $response->assertSessionHas('group.id', $group->id);

        $this->assertEquals($name, $group->name);
        $this->assertEquals($note, $group->note);
    }

    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $group = Group::factory()->create();

        $response = $this->delete(route('group.destroy', $group));

        $response->assertRedirect(route('group.index'));

        $this->assertDeleted($group);
    }
}
