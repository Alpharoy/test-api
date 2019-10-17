<?php

namespace App\Events\Enterprise;

use App\Events\BaseEvent;
use App\Models\Enterprise\Enterprise;

class CreateEvent extends BaseEvent
{
    public $enterprise;

    public function __construct(Enterprise $enterprise)
    {
        parent::__construct();
        $this->enterprise = $enterprise;
    }
}