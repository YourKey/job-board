<?php

namespace Tests\Feature\JobVacancy;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteJobVacancyTest extends TestCase
{
    use RefreshDatabase;

    public function test_destroy_job_cant_be_from_another_user()
    {
        $user1 = User::factory()->create();
        $job = JobVacancy::factory()->create(['user_id' => $user1->id]);
        $user2 = User::factory()->create();

        $this->actingAs($user2);
        $response = $this->delete(route('jobs.destroy', $job));
        $deleted_job = JobVacancy::find($job->id);

        $this->assertAuthenticatedAs($user2);
        $this->assertNotEquals($job->user_id, $user2->id);
        $this->assertModelExists($deleted_job);
        $response->assertStatus(403);
    }

    public function test_destroy_job_can_be_from_user()
    {
        $user = User::factory()->create();
        $job = JobVacancy::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $response = $this->delete(route('jobs.destroy', $job));
        $deleted_job = JobVacancy::find($job->id);

        $this->assertAuthenticatedAs($user);
        $this->assertSoftDeleted($job);
        $response->assertStatus(302);
        $response->assertRedirect(route('jobs.index'));
    }
}
