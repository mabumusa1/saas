<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm;
use Livewire\Livewire;
use Tests\TestCase;

class ProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_profile_information_is_available()
    {
        $this->actingAs($user = User::factory()->create());

        $component = Livewire::test(UpdateProfileInformationForm::class);

        $this->assertEquals($user->first_name, $component->state['first_name']);
        $this->assertEquals($user->last_name, $component->state['last_name']);
        $this->assertEquals($user->email, $component->state['email']);
        $this->assertEquals($user->phone, $component->state['phone']);
        $this->assertEquals($user->job_title, $component->state['job_title']);
        $this->assertEquals($user->employer, $component->state['employer']);
        $this->assertEquals($user->experince, $component->state['experince']);
        $this->assertEquals($user->company_name, $component->state['company_name']);
    }

    public function test_profile_information_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());

        Livewire::test(UpdateProfileInformationForm::class)
                ->set('state', [
                    'first_name' => 'First',
                    'last_name' => 'Last',
                    'email' => 'test@example.com',
                    'phone' => '1234567',
                    'job_title' => 'Developer',
                    'employer' => 'Myself, full-time',
                    'experince' => 'I am a beginner',
                    'company_name' => 'test company',
                ])
                ->call('updateProfileInformation');

        $this->assertEquals('First Last', $user->fresh()->fullname);
        $this->assertEquals('test@example.com', $user->fresh()->email);
    }
}
