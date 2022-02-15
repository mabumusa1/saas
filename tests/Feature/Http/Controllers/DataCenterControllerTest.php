<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\DataCenter;
use App\Models\Datacenter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DataCenterController
 */
class DataCenterControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $dataCenters = DataCenter::factory()->count(3)->create();

        $response = $this->get(route('data-center.index'));

        $response->assertOk();
        $response->assertViewIs('datacenter.index');
        $response->assertViewHas('DataCenters');
    }

    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('data-center.create'));

        $response->assertOk();
        $response->assertViewIs('datacenter.create');
    }

    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\DataCenterController::class,
            'store',
            \App\Http\Requests\DataCenterStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $label = $this->faker->word;
        $region = $this->faker->word;

        $response = $this->post(route('data-center.store'), [
            'label' => $label,
            'region' => $region,
        ]);

        $dataCenters = Datacenter::query()
            ->where('label', $label)
            ->where('region', $region)
            ->get();
        $this->assertCount(1, $dataCenters);
        $dataCenter = $dataCenters->first();

        $response->assertRedirect(route('datacenter.index'));
    }
}
