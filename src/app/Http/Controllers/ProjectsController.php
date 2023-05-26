<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    public function index(){
        $projects = auth()->user()->projects;

        return view('projects.index',compact('projects'));

    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show',compact('project'));
    }

    public function store(){

        $attributes = request()->validate([
            'title'=>'required', 
            'description'=>'required',
            'notes' => 'min:3'
        ]);

        $attributes['owner_id'] = auth()->id();

        $project = auth()->user()->projects()->create($attributes);

        Project::create($attributes);

        return redirect($project->path());

        
    }

    public function create(){
        return view('projects.create');

        
    }


    public function update(Project $project)
    {
        $this->authorize('update', $project);
        
        $project->update([
            'notes' =>request('notes')
        ]);

        return redirect($project->path());
    }
}
