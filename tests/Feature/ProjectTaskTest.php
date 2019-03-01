<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();
        $this->signInUser();

        $project = factory(Project::class)->create([
            'owner_id' => auth()->user()->id
        ]);

        $this->post(route('projects.tasks.store', $project), [
            'body' => 'sim'
        ])->assertStatus(302);

        $this->assertDatabaseHas('tasks', [
            'body' => 'sim'
        ]);
    }
}
