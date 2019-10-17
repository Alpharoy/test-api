<?php

namespace App\Listeners\NaturalPerson\NaturalPersonBankCard;

use Illuminate\Contracts\Queue\ShouldQueue;

class NaturalPersonBankCardSubscriber implements ShouldQueue
{
    public $queue = 'listen-user';

    public static function bankCardVerify($event)
    {
        $naturalPersonBankCard = $event->naturalPersonBankCard;
        if ($naturalPersonBankCard->is_verified) {
            return true;
        }
        // TODO: 银行三要素接口
    }
}
