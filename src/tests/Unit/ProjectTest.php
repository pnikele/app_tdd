<?php

namespace Tests\Unit;

use App\Models\Project;

use App\Models\User;
//use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    // model test
    
    /**
     * A basic unit test example.
     */
    use \Illuminate\Foundation\Testing\RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = Project::factory()->create()->first();

        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {
        $project = Project::factory()->create()->first(); //create a project

        $this->assertInstanceOf(User::class, $project->owner);
    }

    // /** @test */
    // public function it_can_add_a_task()
    // {
    //     $project = Project::factory()->create()->first();

    //     $task = $project->addTask('Test task');

    //     $this->assertCount(1, $project->tasks);
    //     $this->assertTrue($project->tasks->contains($task));
    // }
}
