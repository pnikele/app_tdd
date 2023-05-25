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
}
