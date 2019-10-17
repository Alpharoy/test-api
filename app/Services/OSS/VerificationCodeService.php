<?php

namespace App\Services\OSS;

use App\Services\BaseService;
use Urland\Exceptions\Client\BadRequestException;
use Illuminate\Support\Facades\Cache;
use Urland\Exceptions\Client\TooManyRequestsException;

/**
 * 带验证码的短信类服务
 * Class VerificationCodeService
 *
 * @package App\Services\OSS
 */
class VerificationCodeService extends BaseService
{
    /**
     * 缓存前缀
     *
     * @var string
     */
    protected static $prefix = 'verification_code';

    /**
     * 验证错误最大重试次数
     *
     * @var int
     */
    protected static $maxErrorCount = 10;

    /**
     * @param string $phone
     * @param string $templateName
     * @param string $code
     *
     * @return bool
     * @throws \Exception
     */
    public static function verify($phone, $templateName, $code)
    {
        $cacheKey      = self::$prefix . '|' . $phone . '|' . $templateName;
        $errorCacheKey = self::$prefix . '|error|' . $phone . '|' . $templateName;

        if (Cache::get($errorCacheKey) >= self::$maxErrorCount) {
            throw new TooManyRequestsException('验证次数过于频繁，请稍候再试');
        }

        $cacheCode = Cache::get($cacheKey);
        if ($cacheCode !== $code) {
            if (Cache::has($errorCacheKey)) {
                Cache::increment($errorCacheKey, 1);
            } else {
                Cache::put($errorCacheKey, 1, 60 * 60);
            }
            throw new BadRequestException('验证码不正确');
        }
        // 清除缓存数据
        Cache::forget($cacheKey);
        Cache::forget($errorCacheKey);
        // 清除发送间隔缓存标志
        SmsService::clearCache($phone, $templateName);
        return true;
    }

    /**
     * 发送带验证码的信息
     *
     * @param string $phone         接收短信号码
     * @param string $templateName  模版名称
     * @param array  $appendData    模版数据（不带验证码，验证码统一生成，并且参数为code）
     * @param bool   $phoneInSystem 是否检验接收短信号码是否在本系统注册
     * @param int    $timeInterval  相同模版发送短信间隔，为0表示不限制
     *
     * @return bool
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Urland\Exceptions\Client\BadRequestException
     * @throws \Urland\Exceptions\Client\TooManyRequestsException
     */
    public static function sendVerificationCode(
        $phone,
        $templateName,
        $appendData = [],
        $phoneInSystem = true,
        $timeInterval = 60
    ) {
        $code = sprintf('%06d', rand(0, 999999));
        $data = array_merge($appendData, [
            'code' => $code,
        ]);
        SmsService::send($phone, $templateName, $data, $phoneInSystem, $timeInterval);

        // 没有异常，记录信息
        $cacheKey = self::$prefix . '|' . $phone . '|' . $templateName;

        // 默认验证码类信息，10分钟内有效
        Cache::put($cacheKey, $code, 600);
        return true;
    }
}