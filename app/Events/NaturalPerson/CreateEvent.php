<?php

namespace App\Events\NaturalPerson;

use App\Events\BaseEvent;
use App\Models\NaturalPerson\NaturalPerson;

class CreateEvent extends BaseEvent
{
    public $naturalPerson;

    public function __construct(NaturalPerson $naturalPerson)
    {
        parent::__construct();
        $this->naturalPerson = $naturalPerson;
    }
}