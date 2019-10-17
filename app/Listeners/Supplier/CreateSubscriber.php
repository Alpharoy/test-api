<?php

namespace App\Listeners\Supplier;

use App\Services\Supplier\SupplierUserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\Supplier\CreateEvent;
use Illuminate\Support\Str;

class CreateSubscriber implements ShouldQueue
{
    public $queue = 'listen-supplier';

    /**
     * 创建隐藏管理员
     *
     * @param \App\Events\Supplier\CreateEvent $event
     */
    public static function createHiddenUser(CreateEvent $event)
    {
        $supplier = $event->supplier;
        SupplierUserService::store($supplier->supplier_uuid, cons('user.type.hidden'),
            $supplier->getHiddenUserPhone(),
            Str::random(6));
    }
}
