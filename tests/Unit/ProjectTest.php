<?php

namespace Tests\Unit;

use App\Project;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = factory(Project::class)->create();

        $this->assertInstanceOf('App\User', $project->owner);
    }

    /** @test */
    public function it_has_many_tasks()
    {
        $project = factory(Project::class)->create();
        $task = $project->tasks()->create(
            factory('App\Task')->raw([
                'project_id' => $project->id
            ])
        );

        $this->assertInstanceOf(Collection::class, $project->tasks);
        $this->assertInstanceOf('App\Task', $project->tasks->first());
        $this->assertTrue($project->tasks->contains($task));
    }
}
