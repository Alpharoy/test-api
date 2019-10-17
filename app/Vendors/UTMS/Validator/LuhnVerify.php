<?php

namespace UTMS\Validator;

/**
 * 银行卡 Luhn 算法校验
 * Class LuhnVerify
 *
 * @package UTMS\Validator
 */
class LuhnVerify
{
    /**
     * 验证主体方法
     *
     * @param string $bankCardNo 银行卡卡号
     *
     * @return bool
     */
    public static function validateBankCardNo($bankCardNo)
    {
        if (empty($bankCardNo)) {
            return false;
        }

        if (strlen($bankCardNo) < 10) {
            return false;
        }

        // 确定全部整数
        if (preg_match('/^\d+$/', $bankCardNo) !== 1) {
            return false;
        }
        // 排除全部为0
        if (preg_match('/^0+$/', $bankCardNo) === 1) {
            return false;
        }

        // 2019年7月15日 17:18:19 由于此规则不能验证对公账号银行卡，所以只简单验证是否为纯数字
        return true;

        // 末位数
        $lastNum = (int)substr($bankCardNo, -1);
        // 其他位数
        $otherNum       = substr($bankCardNo, 0, -1);
        $otherNumArray  = array_reverse(str_split($otherNum));
        $otherNumLength = count($otherNumArray);
        $totalSum       = 0;

        for ($i = 0; $i < $otherNumLength; $i++) {
            if ($i % 2) {
                $totalSum += $otherNumArray[$i];
            } else {
                $tmpNum = $otherNumArray[$i] * 2;
                if ($tmpNum < 9) {
                    $totalSum += $tmpNum;
                } else {
                    // 如果乘以2的结果是两位数，将结果减去9。
                    $totalSum += $tmpNum - 9;
                }
            }
        }

        $totalSum = $totalSum % 10;

        $k    = ($totalSum == 0) ? 10 : $totalSum;
        $luhn = 10 - $k;

        if ($lastNum !== $luhn) {
            return false;
        }
        return true;
    }
}