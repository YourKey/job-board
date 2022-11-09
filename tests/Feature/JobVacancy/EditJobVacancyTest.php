<?php

namespace Tests\Feature\JobVacancy;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EditJobVacancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_form_cant_be_rendered_for_guests()
    {
        User::factory()->create();
        $job = JobVacancy::factory()->create();
        $response = $this->get(route('jobs.edit', $job));

        $this->assertGuest();
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));
    }

    public function test_edit_form_cant_be_rendered_for_another_user()
    {
        $user1 = User::factory()->create();
        $job = JobVacancy::factory()->create(['user_id' => $user1->id]);
        $user2 = User::factory()->create();

        $this->actingAs($user2);
        $response = $this->get(route('jobs.edit', $job));

        $this->assertAuthenticatedAs($user2);
        $this->assertNotEquals($job->user_id, $user2->id);
        $response->assertStatus(403);
    }

    public function test_edit_form_can_be_rendered_for_user()
    {
        $user = User::factory()->create();
        $job = JobVacancy::factory()->create([
            'title' => 'title test',
            'description' => 'description test',
        ]);

        $this->actingAs($user);
        $response = $this->get(route('jobs.edit', $job));

        $response->assertOk();
        $response->assertViewIs('jobs.edit');
        $this->assertEquals('title test', $response->original['job']->title);
        $this->assertEquals('description test', $response->original['job']->description);
    }


    public function test_update_job_cant_be_from_another_user()
    {
        $user1 = User::factory()->create();
        $data = JobVacancy::factory()->make(['user_id' => $user1->id])->toArray();
        $job = JobVacancy::factory()->create($data);
        $user2 = User::factory()->create();

        $this->actingAs($user2);
        $response = $this->put(route('jobs.update', $job), $data);

        $this->assertAuthenticatedAs($user2);
        $this->assertNotEquals($job->user_id, $user2->id);
        $response->assertStatus(403);
    }

    public function test_update_job_can_be_from_user()
    {
        $user = User::factory()->create();
        $data = JobVacancy::factory()->make(['user_id' => $user->id])->toArray();
        $job = JobVacancy::factory()->create($data);
        $data['title'] = 'title updated';

        $this->actingAs($user);
        $response = $this->put(route('jobs.update', $job), $data);
        $updated_job = JobVacancy::find($job->id);

        $this->assertAuthenticatedAs($user);
        $this->assertEquals($job->user_id, $user->id);
        $this->assertEquals('title updated', $updated_job->title);
        $response->assertStatus(302);
        $response->assertRedirect(route('jobs.show', $job));
    }
}
