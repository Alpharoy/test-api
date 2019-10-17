<?php

namespace App\Events\Enterprise;

use App\Events\BaseEvent;
use App\Models\Enterprise\Enterprise;

class AuditSuccessEvent extends BaseEvent
{
    public $enterprise;

    public function __construct(Enterprise $enterprise)
    {
        parent::__construct();
        $this->enterprise = $enterprise;
    }
}