<?php

namespace App\Http\Controllers\SupplierApi\Auth;

use App\Events\Supplier\RegisterEvent;
use App\Http\Controllers\SupplierApi\BaseController;
use App\Http\Requests\SupplierApi\Auth\RegisterSendSmsRequest;
use App\Http\Requests\SupplierApi\Auth\RegisterSupplierRequest;
use App\Http\Requests\SupplierApi\Auth\RegisterVerifySmsCodeRequest;
use App\Http\Resources\EmptyResource;
use App\Models\Supplier\SupplierUser;
use App\Services\Auth\VerifyCodeService;
use App\Services\OSS\VerificationCodeService;
use App\Services\Supplier\SupplierService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Urland\Exceptions\Client\BadRequestException;
use Urland\Exceptions\Client\ForbiddenException;

/**
 * 注册服务
 * Class RegisterController
 *
 * @package App\Http\Controllers\SupplierApi\Auth
 */
class RegisterController extends BaseController
{
    /**
     * 发送注册短信
     *
     * @param \App\Http\Requests\SupplierApi\Auth\RegisterSendSmsRequest $request
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
        $exists = SupplierUser::where('user_phone', $userPhone)->exists();
        if ($exists) {
            throw new BadRequestException('该号码已注册供应商账号');
        }
        VerificationCodeService::sendVerificationCode($userPhone, 'supplier_register', [], false);
        return new EmptyResource();
    }

    /**
     * 验证注册短信
     *
     * @param \App\Http\Requests\SupplierApi\Auth\RegisterVerifySmsCodeRequest $request
     *
     * @return \App\Http\Resources\EmptyResource
     * @throws \Exception
     */
    public function verifySmsCode(RegisterVerifySmsCodeRequest $request)
    {
        $inputs  = $request->validated();
        $smsCode = Arr::pull($inputs, 'sms_code');
        $token   = $request->header('X-Api-Token');
        VerificationCodeService::verify($inputs['user_phone'], 'supplier_register', $smsCode);

        // 记录token对应的用户信息，一个小时有效
        Cache::put($this->getCacheKey($token), $inputs, 60 * 60);
        return new EmptyResource();
    }

    /**
     * 注册供应商
     *
     * @param RegisterSupplierRequest $request
     *
     * @return EmptyResource
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(RegisterSupplierRequest $request)
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
        $supplier              = SupplierService::store($inputs, $userData);

        event(new RegisterEvent($supplier));
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
        return "register:{$token}:supplier";
    }
}