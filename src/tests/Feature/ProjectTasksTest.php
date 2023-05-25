<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

        /** @test */
        public function guests_cannot_add_tasks_to_projects()
        {
            //$project = factory('App\Project')->create();
            $project = Project::factory()->create();
    
            $this->post($project->path() . '/tasks')->assertRedirect('login');
        }
    
        /** @test */
        function only_the_owner_of_a_project_may_add_tasks()
        {
            $this->signIn();
    
            $project = Project::factory()->create(); //if i have a project
    
            $this->post($project->path() . '/tasks', ['body' => 'Test task']) //and i try to add a task to a project but i dont have premmision
                ->assertStatus(403);
    
            $this->assertDatabaseMissing('tasks', ['body' => 'Test task']); //there should not be a record
        }

            /** @test */
    function only_the_owner_of_a_project_may_update_a_task()
    {
        $this->signIn(); //sign in
        $project = Project::factory()->create(); //have a project that we did not create

        $task = $project->addTask('test task'); //that project has a task

        // $this->patch($project->tasks[0]->path(), ['body' => 'changed'])
        //      ->assertStatus(403);
        $this->patch($task->path(), ['body' => 'changed']) //if you try to update it then it will fail with status code 403
              ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']); //there should be no record of that change
    }
    
    
        /** @test */
        public function a_project_can_have_tasks()
        {
            $this->signIn();
            $project = Project::factory()->create();
            $this->actingAs($project->owner)
                  ->post($project->path() . '/tasks', ['body' => 'Test task']);

            $this->get($project->path())
                  ->assertSee('Test task');


        }
        /** @test */
        function a_task_can_be_updated()
        {
            $this->withoutExceptionHandling();

            $this->signIn();


            $project = auth()->user()->projects()->create(
                Project::factory()->raw()
            );

            $task = $project->addTask('test task');

            $this->patch($project->path() . '/tasks/' . $task->id, [
                'body' => 'changed',
                'completed' => true
            ]);
    
            $this->assertDatabaseHas('tasks', [
                'body' => 'changed',
                'completed' => true
            ]);
        }
    
    
        /** @test */
        public function a_task_requires_a_body()
        {
            $project = Project::factory()->create();
    
            $attributes = Task::factory()->raw(['body' => '']);
    
            $this->actingAs($project->owner)
                 ->post($project->path() . '/tasks', $attributes)
                ->assertSessionHasErrors('body');
        }
}
