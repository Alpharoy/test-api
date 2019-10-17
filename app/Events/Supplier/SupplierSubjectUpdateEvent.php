<?php

namespace App\Events\Supplier;

use App\Events\BaseEvent;
use App\Models\Supplier\SupplierSubject;

class SupplierSubjectUpdateEvent extends BaseEvent
{
    public $supplierSubject;

    public function __construct(SupplierSubject $supplierSubject)
    {
        parent::__construct();
        $this->supplierSubject = $supplierSubject;
    }
}