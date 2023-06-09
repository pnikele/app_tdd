<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{

    use HandlesAuthorization;

    public function manage(User $user,  Project $project){
        return $user->is($project->owner);

    }

    /**
     * Determine if the user may update the project.
     *
     * @param  User    $user
     * @param  Project $project
     * @return bool
     */
    public function update(User $user, Project $project)
    {
        return $user->is($project->owner) || $project->members->contains($user);
    }
}
