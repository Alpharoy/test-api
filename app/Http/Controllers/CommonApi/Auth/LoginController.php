<?php

namespace App\Http\Controllers\CommonApi\Auth;

use App\Http\Controllers\CommonApi\BaseController;
use App\Http\Requests\CommonApi\Request;
use App\Services\Auth\VerifyCodeService;
use App\Http\Resources\CommonApi\Auth\TokenResource;
use Illuminate\Support\Str;

/**
 * 认证服务
 * Class LoginController
 *
 * @package App\Http\Controllers\CommonApi\Auth
 */
class LoginController extends BaseController
{
    /**
     * 获取token
     *
     * @return \App\Http\Resources\CommonApi\Auth\TokenResource
     * @throws \RuntimeException
     */
    public function getToken()
    {
        $token = Str::random(32);
        return new TokenResource(['token' => $token]);
    }

    /**
     * 生成验证码
     *
     * @param Request $request
     *
     * @return bool
     */
    public function verifyCode(Request $request)
    {
        return (new VerifyCodeService())->bulid($request->input('token'));
    }
}