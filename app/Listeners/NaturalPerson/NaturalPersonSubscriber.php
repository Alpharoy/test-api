<?php

namespace App\Listeners\NaturalPerson;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\NaturalPerson\CreateEvent;

class NaturalPersonSubscriber implements ShouldQueue
{
    public $queue = 'listen-user';

    /**
     * 实名认证
     *
     * @param \App\Events\NaturalPerson\CreateEvent $event
     *
     * @return bool
     */
    public static function nameVerify(CreateEvent $event)
    {
        $naturalPerson = $event->naturalPerson;
        if ($naturalPerson->is_name_verified) {
            return true;
        }
        // TODO: 实名认证接口
    }
}
