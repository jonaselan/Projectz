<?php

namespace Tests\Unit;

use App\Project;
use App\User;
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
}
