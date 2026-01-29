<?php

namespace App\Listeners;

use App\Events\TaskEvent;

class TaskListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TaskEvent $event): void
    {
        info('Test Create Task '.$event->task->title);
    }
}
