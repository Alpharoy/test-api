<?php

namespace App\Listeners\Enterprise;

use App\Events\Enterprise\CreateEvent;
use App\Services\Enterprise\EnterpriseUserService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;

class CreateSubscriber implements ShouldQueue
{
    public $queue = 'listen-enterprise';

    /**
     * 创建隐藏管理员
     *
     * @param \App\Events\Enterprise\CreateEvent $event
     */
    public static function createHiddenUser(CreateEvent $event)
    {
        $enterprise = $event->enterprise;
        EnterpriseUserService::store($enterprise->enterprise_uuid, cons('user.type.hidden'),
            $enterprise->getHiddenUserPhone(),
            Str::random(6));
    }
}
