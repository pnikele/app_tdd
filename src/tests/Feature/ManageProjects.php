<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\ResponseTrait;
use Illuminate\Process\FakeProcessResult;
use Tests\TestCase;

class ManageProjects extends TestCase
{
    use WithFaker,RefreshDatabase;
     /**
     * @test
     */
    public function guests_cannot_manage_projects(){
        //$this->withoutExceptionHandling();

        $project = Project::factory()->create(); //create a project

        //$attributes = Project::factory()->raw();  //if you have a project

        $this->get('/projects')->assertRedirect('login');  //if you try to access the dashboard you should be reedirected
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login'); //if you try to access a specific project you should be redirected

        $this->post('/projects',$project->toArray())->assertRedirect('login'); //try to create a project but you are not signed in 


    }


    //  /**
    //  * @test
    //  */
    // public function guests_cannot_view_projects(){
    //     //$this->withoutExceptionHandling();

    //     //$this->get('/projects')->assertRedirect('login'); 

    // }

    // /**
    //  * @test
    //  */
    // public function guests_cannot_view_a_single_project(){
    //     //$this->withoutExceptionHandling();
    //     //$project = Project::factory()->create();

    //     //$this->get($project->path())->assertRedirect('login'); 

    // }



    /**
     * @test
     */
    public function a_user_can_create_a_project()
    {
        $this->signIn();

        $this->get('/projects/create')->assertStatus(200); //if i visit projects/create i should be able to see it 

        $attributes=[
            'title'=>$this->faker->sentence,
            'description'=>$this->faker->paragraph
        ];
        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());//check if rederected where as expected

        $this->assertDatabaseHas('projects',$attributes); //exptected them to be inserted into the projects table in database

        $this->get('/projects')->assertSee($attributes['title']); //should be able to see it 

    }


    /**
     * @test
     */
    public function a_user_can_view_their_project(){
        $this->signIn();

        $this->withoutExceptionHandling();
        
        $project = Project::factory()->create(['owner_id'=>auth()->id()]);

        $this->get($project->path())
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
