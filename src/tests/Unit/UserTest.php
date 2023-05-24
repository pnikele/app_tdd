<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
//\\use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects()
    {
        //$user = factory('App\User')->create();


        //$user = User::factory()->create()->first();
        $user = User::factory()->create();
        //dd($user);

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
