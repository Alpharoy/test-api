<?php

namespace App\Events\Enterprise;

use App\Events\BaseEvent;
use App\Models\Enterprise\Enterprise;

class RegisterEvent extends BaseEvent
{
    public $enterprise;

    public function __construct(Enterprise $enterprise)
    {
        parent::__construct();
        $this->enterprise = $enterprise;
    }
}