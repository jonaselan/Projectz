<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_create_a_project()
    {
        $this->signInUser();

        $attr = factory(Project::class)->raw();

        $this->post(route('projects.store'), $attr)
                ->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', $attr);
    }

    /** @test */
    public function an_authenticated_user_list_projects()
    {
        $this->signInUser();

        $project = factory(Project::class)->create();

        $this->get(route('projects.index'))->assertSee($project['title']);

    }

    /** @test */
    public function a_authenticated_user_can_view_a_project()
    {
        $this->signInUser();

        $project = factory(Project::class)->create();

        $this->get(route('projects.show', $project))
            ->assertSee($project->title)
            ->assertSee($project->description);

    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signInUser();

        $attr = factory(Project::class)->raw([
            'title' => ''
        ]);

        $this->post(route('projects.store'), $attr)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signInUser();

        $attr = factory(Project::class)->raw([
            'description' => ''
        ]);

        $this->post(route('projects.store'), $attr)->assertSessionHasErrors('description');
    }

    /** @test */
    public function a_project_requires_an_owner()
    {
        $this->signInUser();

        $attr = factory(Project::class)->raw([
            'owner_id' => null
        ]);

        $this->post(route('projects.store'), $attr)->assertSessionHasErrors('owner_id');
    }

}
