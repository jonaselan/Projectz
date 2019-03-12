<?php

namespace App\Observers;

use App\Activity;
use App\Project;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        Activity::create([
            'user_id' => auth()->user()->id,
            'project_id' => $project->id,
            'description' => 'project_created',
        ]);
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        Activity::create([
            'user_id' => auth()->user()->id,
            'project_id' => $project->id,
            'description' => 'project_updated',
        ]);
    }

}
