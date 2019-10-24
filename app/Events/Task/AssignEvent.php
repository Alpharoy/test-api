<?php

namespace App\Events\Task;

use App\Events\BaseEvent;
use App\Models\Task\Task;

class AssignEvent extends BaseEvent
{
    public $task;

    public function __construct(Task $task)
    {
        parent::__construct();
        $this->task = $task;
    }
}