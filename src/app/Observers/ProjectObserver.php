<?php

namespace App\Observers;

use App\Models\Activity;
use App\Models\Project;

class ProjectObserver
{


    public function created(Project $project)
    {
        $project->recordActivity('created');
    }

    public function updating(Project $project) {
        $project->old = $project->getOriginal();
    }


    public function updated(Project $project)
    {
        $project->recordActivity('updated');
    }

    
}
