<?php

namespace Tests\Feature;

use App\Project;
use App\User;
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

        $this->get(route('projects.create'))->assertStatus(200);

        $this->post(route('projects.store'), $attr)
                ->assertRedirect(route('projects.index'));

        $this->assertDatabaseHas('projects', $attr);
    }

    /** @test */
    public function an_authenticated_user_list_projects_that_he_created()
    {
        $auth_user = factory(User::class)->create();
        $this->signInUser($auth_user);
        $user_project = factory(Project::class)->create([
            'owner_id' => $auth_user->id
        ]);

        $other_user = factory(User::class)->create();
        $other_project = factory(Project::class)->create([
            'owner_id' => $other_user->id
        ]);

        $this->get(route('projects.index'))
            ->assertSee($user_project['title'])
            ->assertDontSee($other_project['title']);
    }

    /** @test */
    public function a_authenticated_user_can_view_only_project_that_he_created()
    {
        $auth_user = factory(User::class)->create();
        $this->signInUser($auth_user);
        $user_project = factory(Project::class)->create([
            'owner_id' => $auth_user->id
        ]);

        $other_user = factory(User::class)->create();
        $other_project = factory(Project::class)->create([
            'owner_id' => $other_user->id
        ]);

        $this->get(route('projects.show', $user_project))
            ->assertSee($user_project->title)
            ->assertDontSee($other_project->title);

        $this->get(route('projects.show', $other_project))
            ->assertStatus(403);
    }

    /** @test */
    public function guest_may_not_list_projects()
    {
        $this->get(route('projects.index'))->assertRedirect('login');
    }

    /** @test */
    public function guest_may_not_view_form_for_create_projects()
    {
        $this->get(route('projects.create'))->assertRedirect('login');
    }

    /** @test */
    public function guest_may_not_view_a_single_project()
    {
        $project = factory(Project::class)->create();

        $this->get(route('projects.show', $project))->assertRedirect('login');
    }

    /** @test */
    public function guest_may_not_create_a_project()
    {
        $this->post(route('projects.store'))->assertRedirect('login');
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
