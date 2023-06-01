<?php

namespace Tests\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use lluminate\Foundation\Testing\DatabaseMigrations;
use App\Models\Task;
use App\Models\Project;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function it_belongs_to_a_project()
    {
        $this->withoutExceptionHandling();
        $task = Task::factory()->create();

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    function it_has_a_path()
    {
        $task = Task::factory()->create();

        $this->assertEquals("/projects/{$task->project->id}/tasks/{$task->id}", $task->path());
    }

    /** @test */
    function it_can_be_completed()
    {
        $task = Task::factory()->create();

        $this->assertFalse($task->completed); //completed is false

        $task->complete();

        $this->assertTrue($task->fresh()->completed); //should change to true
    }

        /** @test */
        function it_can_be_marked_as_incomplete()
        {
            $task = Task::factory()->create(['completed' => true]);
    
            $this->assertTrue($task->completed); //task should be completed
    
            $task->incomplete();//mark as incomplete
    
            $this->assertFalse($task->fresh()->completed);//should be incomplete
        }


}
