<?php

namespace App\Listeners\Supplier;

use App\Events\Supplier\SupplierSubjectUpdateEvent;
use App\Services\Supplier\SupplierSubjectService;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Str;

class SupplierSubjectSubscriber implements ShouldQueue
{
    public $queue = 'listen-supplier';

    /**
     * @param \App\Events\Supplier\SupplierSubjectUpdateEvent $event
     */
    public static function openStatusEffect(SupplierSubjectUpdateEvent $event)
    {
        $supplierSubject = $event->supplierSubject;
        SupplierSubjectService::openStatusEffect($supplierSubject);
    }
}
