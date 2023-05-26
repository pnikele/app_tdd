<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

        /** @test */
        public function guests_cannot_add_tasks_to_projects()
        {
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

        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'changed']) //if you try to update it then it will fail with status code 403
              ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']); //there should be no record of that change
    }
    
    
        /** @test */
        public function a_project_can_have_tasks()
        {
            $project = ProjectFactory::create();

            $this->actingAs($project->owner)
                  ->post($project->path() . '/tasks', ['body' => 'Test task']);

            $this->get($project->path())
                  ->assertSee('Test task');


        }
        /** @test */
        function a_task_can_be_updated()
        {
            $project = ProjectFactory::withTasks(1)->create();

            $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
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

            $project = ProjectFactory::create();
    
            $attributes = Task::factory()->raw(['body' => '']);
    
            $this->actingAs($project->owner)
                 ->post($project->path() . '/tasks', $attributes)
                ->assertSessionHasErrors('body');
        }
}
