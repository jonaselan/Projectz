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
        $attr = factory(Project::class)->raw();

        $this->post(route('projects.store'), $attr)->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', $attr);

    }

    /** @test */
    public function an_user_list_projects()
    {
        $project = factory(Project::class)->create();

        $this->get(route('projects.index'))->assertSee($project['title']);

    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $attr = factory(Project::class)->raw([
            'title' => ''
        ]);

        $this->post(route('projects.store'), $attr)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $attr = factory(Project::class)->raw([
            'description' => ''
        ]);

        $this->post(route('projects.store'), $attr)->assertSessionHasErrors('description');
    }
}
