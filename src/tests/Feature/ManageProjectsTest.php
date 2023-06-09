<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Carbon\Factory;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\ResponseTrait;
use Illuminate\Process\FakeProcessResult;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker,RefreshDatabase;
    //   guests_cannot_view_projects
    //  guests_cannot_view_a_single_project
     /**
     * @test
     */
    public function guests_cannot_manage_projects(){
        $project = Project::factory()->create(); //create a project
        $this->get('/projects')->assertRedirect('login');  //if you try to access the dashboard you should be reedirected
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path().'edit')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login'); //if you try to access a specific project you should be redirected
        $this->post('/projects',$project->toArray())->assertRedirect('login'); //try to create a project but you are not signed in 


    }
    /**
     * @test
     */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200); //if i visit projects/create i should be able to see it 

        $attributes= Project::factory()->raw();

        $response = $this->followingRedirects()->post('/projects', $attributes);


        $response
            ->assertSee($attributes['title']) //should be able to see it 
            ->assertSee($attributes['description']) //should be able to see it 
            ->assertSee($attributes['notes']); //should be able to see it 

    }

    /**
     * @test
     */
    function tasks_can_be_included_as_part_a_new_project_creation()
    {
        $this->signIn();

        $attributes = Project::factory()->raw();

        $attributes['tasks'] = [
            ['body' => 'Task 1'],
            ['body' => 'Task 2']
        ];

        $this->post('/projects', $attributes);

        $this->assertCount(2, Project::first()->tasks);
    }
    /** @test */
    function a_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $user = $this->signIn();

        $project = ProjectFactory::create();

        $project->invite($user);

        $this->get('/projects')->assertSee($project->title);
    }

        /** @test */
        function unauthorized_users_cannot_delete_projects()
        {
            $project = ProjectFactory::create();
    
            $this->delete($project->path())
                ->assertRedirect('/login');
    
            $user = $this->signIn();
    
            $this->delete($project->path())
                 ->assertStatus(403);

            $project->invite($user);

            $this->actingAs($user)->delete($project->path())
            ->assertStatus(403);
        }
    
        /** @test */
        function a_user_can_delete_a_project()
        {
            $project = ProjectFactory::create();
    
            $this->actingAs($project->owner)
                ->delete($project->path())
                ->assertRedirect('/projects');
    
            $this->assertDatabaseMissing('projects', $project->only('id'));
        }


    /** @test */
    function a_user_can_update_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(),$attributes = ['title' => 'Changed', 'description' => 'Changed', 'notes' => 'Changed'])
            ->assertRedirect($project->path());

            $this->get($project->path().'/edit')->assertOk();
            $this->assertDatabaseHas('projects',$attributes);
    }

        /** @test */
    function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['notes' => 'Changed']);

        $this->assertDatabaseHas('projects', $attributes);
    }


    /**
     * @test
     */
    public function a_user_can_view_their_project(){

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();


        $this->get($project->path())->assertStatus(403);
    }
    
        /**
     * @test
     */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = Project::factory()->create();


        $this->patch($project->path(),[])->assertStatus(403);
    }


    /**
     * @test
     */
    public function a_project_requires_a_title(){
        $this->signIn();

        $attributes = Project::factory()->raw(['title'=>'']);
        $this->post('/projects',$attributes)->assertSessionHasErrors('title'); //assert that there is a title error

    }

    /**
     * @test
     */
    public function a_project_requires_a_description(){
        //$this->actingAs(User::factory()->create());//sign a user in
        $this->signIn();
        $attributes = Project::factory()->raw(['description'=>'']);
        $this->post('/projects',$attributes)->assertSessionHasErrors('description'); //assert that there is a title error

    }


}
