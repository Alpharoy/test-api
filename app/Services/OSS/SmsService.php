<?php

namespace App\Services\OSS;

use App\Models\Initial\SmsLog;
use App\Models\Auth\UserLogin;
use App\Services\BaseService;
use Overtrue\EasySms\EasySms;
use Overtrue\EasySms\Exceptions\NoGatewayAvailableException;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\TooManyRequestsException;
use Illuminate\Support\Facades\Cache;

/**
 * 短信服务
 * Class SmsService
 *
 * @package App\Services\OSS
 */
class SmsService extends BaseService
{
    protected static $prefix = 'time_interval';

    /**
     * 短信发送方法
     *
     * @param string $phone         接收短信号码
     * @param string $templateName  模版名称
     * @param array  $data          模版数据
     * @param bool   $phoneInSystem 是否检验接收短信号码是否在本系统注册
     * @param int    $timeInterval  相同模版发送短信间隔，为0表示不限制
     *
     * @return bool
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Urland\Exceptions\Client\BadRequestException
     * @throws \Urland\Exceptions\Client\TooManyRequestsException
     */
    public static function send($phone, $templateName, $data = [], $phoneInSystem = false, $timeInterval = 0)
    {
        // 非手机号码
        if (preg_match('/^1[0-9]{10}$/', $phone) !== 1) {
            return false;
        }

        // 比较同一模版发送时间间隔
        if ($timeInterval) {
            $cacheKey = self::$prefix . '|' . $phone . '|' . $templateName;
            if (!is_null(Cache::get($cacheKey))) {
                throw new TooManyRequestsException('请稍候再尝试');
            }
            Cache::put($cacheKey, true, $timeInterval);
        }

        // 检查发送号码是否在系统内
        if ($phoneInSystem) {
            $userLogin = UserLogin::where('login_type', cons('user.login.type.phone'))->where('login_value',
                $phone)->first();
            if (empty($userLogin)) {
                throw new BadRequestException('接收短信号码不在本系统注册');
            }
        }
        return self::sendSms($phone, $templateName, $data);
    }

    /**
     * 清除短信发送间隔标志
     *
     * @param string $phone        接收短信号码
     * @param string $templateName 模版名称
     *
     * @return bool
     */
    public static function clearCache($phone, $templateName)
    {
        $cacheKey = self::$prefix . '|' . $phone . '|' . $templateName;
        Cache::forget($cacheKey);
        return true;
    }

    /**
     * 发送短信接口
     *
     * @param string $phone        发送号码
     * @param string $templateName 模版名称
     * @param array  $data         模版数据
     * @param string $gateway      发送渠道
     *
     * @return bool
     * @throws \Illuminate\Database\Eloquent\MassAssignmentException
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    protected static function sendSms($phone, $templateName, $data = [], $gateway = 'aliyun')
    {
        $gatewayClass = '\UTMS\Platform\Sms\Gateway\\' . ucfirst(strtolower($gateway));

        $template = $gatewayClass::format($templateName, $data);

        // 保存到数据库
        $smsLog = SmsLog::create([
            'content'       => $template['content'],
            'template'      => $template['template'],
            'data'          => $template['data'],
            'receive_phone' => $phone,
            'send_status'   => cons('misc.sms.status.init'),
            'gateway'       => $gateway,
        ]);

        $sendStatus = cons('misc.sms.status.failure');
        $easySms    = new EasySms(config('sms'));
        try {
            $response        = $easySms->send($phone, $template);
            $gatewayResponse = $response[$gateway];
            if ($gatewayResponse['status'] === 'success') {
                $sendStatus = cons('misc.sms.status.success');
                $result     = '';
            } else {
                $exception = $gatewayResponse['exception'];
                $result    = $exception->getMessage();
            }
        } catch (NoGatewayAvailableException $e) {
            $response        = $e->getResults();
            $gatewayResponse = $response[$gateway];
            $exception       = $gatewayResponse['exception'];
            $result          = $exception->getMessage();
        }

        $smsLog->fill(['send_status' => $sendStatus, 'result' => $result])->save();
        return true;
    }
}