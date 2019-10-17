<?php

namespace UTMS\Exceptions\Account;

use Urland\Exceptions\Client\BaseException;

/**
 * 余额不足异常
 *
 * Class NotEnoughBalanceException
 *
 * @package UTMS\Exceptions\Account
 */
class NotEnoughBalanceException extends BaseException
{
    /**
     * NotEnoughBalanceException constructor.
     *
     * @param string          $message
     * @param \Exception|null $previous
     */
    public function __construct(string $message = '余额不足', \Exception $previous = null)
    {
        parent::__construct(400, $message, $previous, [], 1001);
    }
}
