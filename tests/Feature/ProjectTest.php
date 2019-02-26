<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $attr = factory(Project::class)->raw();

        $this->post(route('projects.store'), $attr)->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', $attr);

    }

    /** @test */
    public function an_user_list__projects()
    {
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create();

        $this->get(route('projects.index'))->assertSee($project['title']);

    }
}
