<?php

namespace App\Services\Auth;

use App\Services\BaseService;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Support\Facades\Cache;
use Urland\Exceptions\Client;

/**
 * 登录验证码服务
 * Class VerifyCodeService
 *
 * @package App\Services\Auth
 */
class VerifyCodeService extends BaseService
{
    /**
     * 校验验证码
     *
     * @param string $token
     * @param string $verifyCode
     *
     * @return bool
     * @throws Client\BadRequestException
     */
    public static function verify($token, $verifyCode)
    {
        $verifyCode = strtoupper($verifyCode);
        if (empty($token)) {
            throw new Client\BadRequestException('操作失败');
        }
        $cacheKey = self::tokenCacheKey($token);
        $captcha  = Cache::get($cacheKey);
        if (!$captcha) {
            throw new Client\BadRequestException('验证码已失效，请重新获取验证码');
        }
        if (!hash_equals($captcha, $verifyCode)) {
            throw new Client\BadRequestException('验证码输入错误');
        }
        Cache::forget($cacheKey);
        return true;
    }

    /**
     * 生成验证码
     *
     * @param string $token
     */
    public static function bulid($token)
    {
        if (empty($token)) {
            throw new Client\BadRequestException('获取验证码失败');
        }
        $phraseBuilder = new PhraseBuilder(4, '2345679ACDEFGHJKMNPQRSTUVWXYZ');
        $builder       = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build();

        $cacheKey = self::tokenCacheKey($token);
        Cache::put($cacheKey, $builder->getPhrase(), 5 * 60);

        header('Content-type: image/jpeg');
        $builder->output();
    }

    /**
     * 获取适用于token的缓存key
     *
     * @param string $token
     *
     * @return string
     */
    protected static function tokenCacheKey($token)
    {
        return "login:token:{$token}:verify_code";
    }
}
