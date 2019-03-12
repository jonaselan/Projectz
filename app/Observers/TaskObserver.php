<?php

namespace App\Observers;

use App\Activity;
use App\Task;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        Activity::create([
            'user_id' => auth()->user()->id,
            'project_id' => $task->project->id,
            'description' => 'task_created',
        ]);
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        Activity::create([
            'user_id' => auth()->user()->id,
            'project_id' => $task->project->id,
            'description' => 'task_updated',
        ]);
    }

}
