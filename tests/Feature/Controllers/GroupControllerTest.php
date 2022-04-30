<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Group;
use App\Models\Site;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GroupController
 */
class GroupControllerTest extends TestCase
{
    use RefreshDatabase;

    private $group;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();

        $this->group = Group::factory()
        ->for($this->account)
        ->create([
            'name' => 'test',
            'notes' => 'test',
        ]);
    }

    /**
     * @test
     */
    public function index_displays_view()
    {
        $response = $this->call('GET', route('groups.index', $this->account), ['q'=>'test']);
        $response->assertOk();
        $response->assertViewIs('groups.index');
        $response->assertViewHas('account');
    }

    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('groups.create', $this->account));
        $response->assertOk();
        $response->assertViewIs('groups.create');
        $response->assertViewHas('account');
    }

    /**
     * @test
     */
    public function test_successful_store()
    {
        $data = [
            'name'=>'admin',
            'notes'=>122,
        ];
        $response = $this->post(route('groups.store', $this->account), $data)
        ->assertStatus(302);
        $this->assertDatabaseHas('groups', $data);
    }

    /**
     * @test
     */
    public function test_failed_store()
    {
        $data = [];
        $response = $this->post(route('groups.store', $this->account), $data);

        $response->assertRedirect();
        $this->assertEquals(session('errors')->get('name')[0], 'The name field is required.');
    }

    /**
     * @test
     */
    public function test_edit()
    {
        $this->get(route('groups.edit', [$this->account, $this->group]))
        ->assertOk()
        ->assertViewIs('groups.edit')
        ->assertViewHas('account')
        ->assertViewHas('group')
        ->assertViewHas('sites')
        ->assertViewHas('groups');
    }

    /**
     * @test
     */
    public function test_update_with_sites()
    {
        $data = [
            'name'=>'test group',
            'notes'=>55,
            'sites'=>[$this->site->id],
        ];
        $this->put(route('groups.update', [$this->account, $this->group]), $data)
                    ->assertStatus(302);
        $this->assertDatabaseHas('groups', ['name' => 'test group']);
        $this->assertDatabaseHas('group_site', ['group_id' => $this->group->id, 'site_id' => $this->site->id]);
    }

    /**
     * @test
     */
    public function test_update_with_no_sites()
    {
        $data = [
            'name'=>'test group',
            'notes'=>55,
        ];
        $this->put(route('groups.update', [$this->account, $this->group]), $data)
                    ->assertStatus(302);
        $this->assertDatabaseHas('groups', ['name' => 'test group']);
        $this->assertDatabaseMissing('group_site', ['group_id' => $this->group->id]);
    }

    /**
     * @test
     */
    public function test_failed_update()
    {
        $data = [];
        $response = $this->put(route('groups.update', [$this->account, $this->group]), $data);
        $response->assertRedirect();
        $this->assertEquals(session('errors')->get('name')[0], 'The name field is required.');
    }

    /**
     * @test
     */
    public function test_delete()
    {
        $response = $this->delete(route('groups.destroy', [$this->account, $this->group]))
        ->assertStatus(302);
        $this->assertDatabaseMissing('groups', $this->group->toArray());
        $this->assertDatabaseMissing('group_site', ['group_id' => $this->group->id]);
    }
}
