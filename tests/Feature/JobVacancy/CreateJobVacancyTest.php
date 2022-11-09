<?php

namespace Tests\Feature\JobVacancy;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateJobVacancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_form_cant_be_rendered_for_guests()
    {
        $response = $this->get(route('jobs.create'));

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_create_form_can_be_rendered()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->get(route('jobs.create'));

        $response->assertOk();
        $response->assertViewIs('jobs.create');
    }

    public function test_guest_cant_be_store_job()
    {
        User::factory()->create();
        $job = JobVacancy::factory()->make()->toArray();

        $response = $this->post(route('jobs.store'), $job);

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_be_store_job()
    {
        $user = User::factory()->create();
        $job = JobVacancy::factory()->make()->toArray();

        $this->actingAs($user);
        $response = $this->post(route('jobs.store', $job));

        $this->assertAuthenticatedAs($user);
        $response->assertStatus(302);
        $response->assertRedirect(route('jobs.show', 1));
    }

    /**
     * @dataProvider storeValidationProvider
     */
    public function test_store_validation(array $request, int $status)
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->postJson(route('jobs.store', $request));

        $response->assertStatus($status);
    }

    public function storeValidationProvider()
    {
        return [
            'success' => [
                ['title' => 'test title', 'description' => 'test description'],
                302
            ],
            'failed' => [
                ['title' => 'test title'],
                422,
                ['description' => 'test description'],
                422,
                ['title' => 'te', 'description' => 'test description'],
                422,
                ['title' => 12345, 'description' => 'test description'],
                422,
                ['title' => '     ', 'description' => '     '],
                422
            ],
        ];
    }
}
