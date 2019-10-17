<?php

namespace UTMS\Events;

/**
 * 状态切换成功事件
 * Class ChangeStatusEvent
 *
 * @package App\Vendors\UTMS\Events
 */
class ChangeStatusEvent extends BaseEvent
{
    public $symbol;
    public $model;
    public $currentStatusValue;
    public $nextStatusValue;
    public $extend;

    public function __construct($symbol, $model, $currentStatusValue, $nextStatusValue, $extend)
    {
        $this->symbol = $symbol;

        $this->model = $model;

        $this->currentStatusValue = $currentStatusValue;

        $this->nextStatusValue = $nextStatusValue;

        $this->extend = $extend;
    }
}