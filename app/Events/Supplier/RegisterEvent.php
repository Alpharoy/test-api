<?php

namespace App\Events\Supplier;

use App\Events\BaseEvent;
use App\Models\Supplier\Supplier;

class RegisterEvent extends BaseEvent
{
    public $supplier;

    public function __construct(Supplier $supplier)
    {
        parent::__construct();
        $this->supplier = $supplier;
    }
}