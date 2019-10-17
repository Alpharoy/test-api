<?php

namespace App\Http\Controllers\EnterpriseApi\Auth;

use App\Events\Enterprise\RegisterEvent;
use App\Http\Controllers\EnterpriseApi\BaseController;
use App\Http\Requests\EnterpriseApi\Auth\RegisterSendSmsRequest;
use App\Http\Requests\EnterpriseApi\Auth\RegisterVerifySmsCodeRequest;
use App\Http\Requests\EnterpriseApi\Auth\RegisterEnterpriseRequest;
use App\Http\Resources\EmptyResource;
use App\Models\Enterprise\EnterpriseUser;
use App\Services\Auth\VerifyCodeService;
use App\Services\Enterprise\EnterpriseService;
use App\Services\OSS\VerificationCodeService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;

/**
 * 注册服务
 * Class RegisterController
 *
 * @package App\Http\Controllers\EnterpriseApi\Auth
 */
class RegisterController extends BaseController
{
    /**
     * 发送注册短信
     *
     * @param \App\Http\Requests\EnterpriseApi\Auth\RegisterSendSmsRequest $request
     *
     * @return \App\Http\Resources\EmptyResource
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     */
    public function sendSms(RegisterSendSmsRequest $request)
    {
        $inputs    = $request->validated();
        $userPhone = $inputs['user_phone'];
        $token     = $request->header('X-Api-Token');

        Cache::forget($this->getCacheKey($token));
        // 校验验证码是否正确
        VerifyCodeService::verify($token, $inputs['verify_code']);

        // 检查此号码有没有注册
        $exists = EnterpriseUser::where('user_phone', $userPhone)->exists();
        if ($exists) {
            throw new BadRequestException('该号码已注册企业账号');
        }
        VerificationCodeService::sendVerificationCode($userPhone, 'enterprise_register', [], false);
        return new EmptyResource();
    }

    /**
     * 验证注册短信
     *
     * @param \App\Http\Requests\EnterpriseApi\Auth\RegisterVerifySmsCodeRequest $request
     *
     * @return \App\Http\Resources\EmptyResource
     * @throws \Exception
     */
    public function verifySmsCode(RegisterVerifySmsCodeRequest $request)
    {
        $inputs  = $request->validated();
        $smsCode = Arr::pull($inputs, 'sms_code');
        $token   = $request->header('X-Api-Token');
        VerificationCodeService::verify($inputs['user_phone'], 'enterprise_register', $smsCode);

        // 记录token对应的用户信息，一个小时有效
        Cache::put($this->getCacheKey($token), $inputs, 60 * 60);
        return new EmptyResource();
    }

    /**
     * 企业注册
     *
     * @param \App\Http\Requests\EnterpriseApi\Auth\RegisterEnterpriseRequest $request
     *
     * @return \App\Http\Resources\EmptyResource
     */
    public function store(RegisterEnterpriseRequest $request)
    {
        $inputs = $request->validated();
        $token  = $request->header('X-Api-Token');
        // 避免用户直接来到这一步，将注册用户信息从缓存中读出来
        $userData = Cache::get($this->getCacheKey($token));
        if (!$userData) {
            throw new ForbiddenException('请先进行手机验证码校验');
        }
        $inputs['status']      = cons('common.audit_status.unaudited');
        $inputs['source_from'] = cons('common.source_from.register');
        $enterprise            = EnterpriseService::store($inputs, $userData);

        // 抛出注册成功事件
        event(new RegisterEvent($enterprise));
        return new EmptyResource();
    }

    /**
     * 获取缓存key
     *
     * @param string $token
     *
     * @return string
     */
    protected function getCacheKey($token)
    {
        return "register:{$token}:enterprise";
    }
}