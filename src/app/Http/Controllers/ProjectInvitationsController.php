<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectINvitationRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectInvitationsController extends Controller
{

    
    public function store(Project $project, ProjectINvitationRequest $request)
    {
        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
