<?php

namespace Tests\Feature\JobVacancy;

use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ShowJobVacancyTest extends TestCase
{
    use RefreshDatabase;

    /**
     *
     * @return void
     */
    public function test_jobs_index_can_be_rendered()
    {
        $response = $this->get(route('jobs.index'));

        $response->assertOk();
        $response->assertViewIs('jobs.index');
        $this->assertEquals(0, $response->original['jobs']->count());
    }

    public function test_jobs_index_models_has_exists()
    {
        User::factory()->create();
        JobVacancy::factory()->create([
            'title' => 'title test',
            'description' => 'description test'
        ]);

        $response = $this->get(route('jobs.index'));

        $response->assertOk();
        $response->assertViewIs('jobs.index');
        $this->assertEquals(1, $response->original['jobs']->count());
        $this->assertEquals('title test', $response->original['jobs']->first()->title);
        $this->assertEquals('description test', $response->original['jobs']->first()->description);
        $response->assertSeeText('title test');
    }

    public function test_jobs_show_page_can_be_render()
    {
        User::factory()->create();
        $job = JobVacancy::factory()->create([
            'title' => 'title test',
            'description' => 'description test'
        ]);

        $response = $this->get(route('jobs.show', $job));

        $response->assertOk();
        $response->assertViewIs('jobs.show');
        $this->assertEquals('title test', $response->original['job']->title);
        $this->assertEquals('description test', $response->original['job']->description);
        $response->assertSeeText('title test');
        $response->assertSeeText('description test');
    }
}
