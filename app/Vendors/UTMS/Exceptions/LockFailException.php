<?php

namespace UTMS\Exceptions;

use Urland\Exceptions\Server\BaseException;

/**
 * 余额不足异常
 *
 * Class NotEnoughBalanceException
 *
 * @package UTMS\Exceptions\Account
 */
class LockFailException extends BaseException
{
    var $model;

    /**
     * NotEnoughBalanceException constructor.
     *
     * @param string $message
     * @param        $model
     */
    public function __construct(string $message = '锁定失败，请勿重复操作', $model = null)
    {
        $this->model = $model;
        parent::__construct(503, $message, null, [], 5500);
    }
}
