<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_may_not_create_projects()
    {
        $project = factory(Project::class)->create();

        $this->post(route('projects.tasks.store', $project))
            ->assertRedirect('login');
    }

    /** @test */
    public function only_member_of_a_project_can_add_tasks_to_a_project()
    {
        $this->signInUser();

        $project = factory(Project::class)->create();

        $this->post(route('projects.tasks.store', $project), [
            'body' => 'task body test'
        ])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
           'body' => 'task body test'
        ]);
    }

    /** @test */
    function a_task_can_be_updated()
    {
        $this->signInUser();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $this->post(route('projects.tasks.store', $project), [
            'body' => 'task body test'
        ]);
        $task = Task::all()->first();

        $this->patch(route('projects.tasks.update', [$project, $task]), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    public function sync_updated_at_of_project_when_update_related_task()
    {
        $this->signInUser();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw([
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ])
        );

        $this->post(route('projects.tasks.store', $project), [
            'body' => 'task body test'
        ]);
        /** @var Task $task */
        $task = Task::all()->first();

        $this->patch(route('projects.tasks.update', [$project, $task]), [
            'body' => 'changed',
            'completed' => true
        ]);

        $project->refresh();
        $this->assertEquals($task->updated_at, $project->updated_at);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signInUser();

        $project = factory(Project::class)->create([
            'owner_id' => auth()->user()->id
        ]);

        $this->post(route('projects.tasks.store', $project), [
            'body' => 'task body test'
        ])->assertStatus(302);

        $this->get(route('projects.show', $project))
            ->assertSee('task body test');

        $this->assertDatabaseHas('tasks', [
            'body' => 'task body test'
        ]);
    }

    /** @test */
    public function task_requires_a_body()
    {
        $this->signInUser();

        $project = factory(Project::class)->create();
        $attr = factory(Task::class)->raw([
            'body' => ''
        ]);

        $this->post(route('projects.tasks.store', $project), $attr)
            ->assertSessionHasErrors('body');
    }
}
