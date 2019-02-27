<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_many_projects()
    {
        $user = factory(User::class)->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
