<?php

namespace App\Services\Auth;

use App\Services\BaseService;
use App\Models\Auth\UserToken;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Urland\Exceptions\Client;

/**
 * Class TokenService
 *
 * @package App\Services\Auth
 */
class TokenService extends BaseService
{
    /**
     * 更新用户登录token
     *
     * @param int    $userGroup
     * @param string $userUUID
     * @param string $loginGroup
     *
     * @param null   $tokenExpiry
     *
     * @return string
     * @throws \RuntimeException
     */
    public static function updateToken($userGroup, $userUUID, $loginGroup, $tokenExpiry = null)
    {
        do {
            $token = Str::random(32);
        } while (UserToken::where('token', $token)->exists());

        $where = [
            'user_group'  => $userGroup,
            'user_uuid'   => $userUUID,
            'token_group' => $loginGroup,
        ];

        if (is_null($tokenExpiry)) {
            $tokenExpiry = cons('user.login.token_expiry');
        }

        $updateData = [
            'token'              => $token,
            'last_activity_time' => Carbon::now()->addSecond($tokenExpiry),
        ];
        UserToken::updateOrCreate($where, $updateData);
        return $token;
    }

    /**
     * 检验token的有效值
     *
     * @param string $tokenValue
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public static function validateToken($tokenValue)
    {
        $token = UserToken::where('token', $tokenValue)->first([
            'id',
            'user_group',
            'user_uuid',
            'last_activity_time',
        ]);
        if (empty($token)) {
            throw new Client\AuthenticationException('登录信息无效，请重新登录');
        } elseif ($token->last_activity_time < Carbon::now()) {
            throw new Client\AuthenticationException('登录信息已过期，请重新登录');
        }

        return $token;
    }

    /**
     * 用户下UUID下的所有TOKEN设置为过期
     *
     * @param string $userUUID
     * @param string $tokenGroup 如为null，则清空所有分组的token
     *
     * @return bool
     */
    public static function setTimeOutTokenByUUID($userUUID, $tokenGroup = null)
    {
        $query = UserToken::where('user_uuid', $userUUID);
        if (!is_null($tokenGroup)) {
            $query->where('token_group', $tokenGroup);
        }

        $query->update(['last_activity_time' => Carbon::now()]);
        return true;
    }

    /**
     * 禁止用户设置TOKEN为null
     *
     * @param string $userUUID
     * @param int    $userGroup
     * @param int    $tokenGroup
     *
     * @return bool
     */
    public static function logout($userUUID, $userGroup = null, $tokenGroup = null)
    {
        $query = UserToken::where('user_uuid', $userUUID);
        if (!empty($userGroup)) {
            $query->where('user_group', $userGroup);
        }
        if (!empty($tokenGroup)) {
            $query->where('token_group', $tokenGroup);
        }

        $userTokens = $query->get(['id']);

        foreach ($userTokens as $userToken) {
            $userToken->setAttribute('token', null)->save();
        }

        return true;
    }


}
