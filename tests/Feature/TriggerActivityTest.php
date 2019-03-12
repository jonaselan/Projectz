<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function register_when_create_a_new_project()
    {
        $user = $this->signInUser();

        $project = factory(Project::class)->create([
            'owner_id' => $user->id
        ]);

        $this->assertDatabaseHas('activities', [
           'project_id' => $project->id,
           'user_id' => $user->id,
           'description' => 'project_created'
        ]);
    }

    /** @test */
    public function register_when_upgrade_a_existent_project()
    {
        $user = $this->signInUser();

        $project = factory(Project::class)->create();

        $project->update([
           'title' => 'title changed'
        ]);

        $this->assertEquals(2, $project->activities()->count());
        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'description' => 'project_updated'
        ]);
    }

    /** @test */
    public function register_when_create_a_new_task()
    {
        $user = $this->signInUser();

        $task = factory(Task::class)->create();
        $project = $task->project;

        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'description' => 'project_created'
        ]);
    }

    /** @test */
    public function register_when_upgrade_a_existent_task()
    {
        $user = $this->signInUser();

        $task = factory(Task::class)->create();
        $project = $task->project;

        $task->update([
            'body' => 'body changed'
        ]);

        $this->assertEquals(3, $project->activities()->count());

        $this->assertDatabaseHas('activities', [
            'project_id' => $project->id,
            'user_id' => $user->id,
            'description' => 'task_updated'
        ]);
    }
}
