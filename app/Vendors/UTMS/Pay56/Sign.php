<?php

namespace UTMS\Pay56;

use Urland\Exceptions\Client;

class Sign
{
    /**
     * 参数构建
     *
     * @param $params
     * @param $apiKey
     * @param $apiSecretFile
     *
     * @return array
     */
    static function build($params, $apiKey, $apiSecretFile)
    {
        $params['api_key'] = $apiKey;
        $params['time']    = (new \DateTime())->getTimestamp();

        $merchantPrivateKey = file_get_contents(storage_path($apiSecretFile));
        $privateKeyId       = openssl_get_privatekey($merchantPrivateKey);
        openssl_sign(self::getSignMd5($params), $sign, $privateKeyId);
        openssl_free_key($privateKeyId);
        $params['sign'] = base64_encode($sign);

        return $params;
    }

    /**
     * 签名验证
     *
     * @param $params
     * @param $payPublicFile
     *
     * @return bool
     * @throws \Urland\Exceptions\Client\BadRequestException
     */
    static function sigVerif($params, $payPublicFile)
    {
        $merchantPrivateKey = file_get_contents(storage_path($payPublicFile));
        $publicKeyId        = openssl_get_publickey($merchantPrivateKey);

        $sign   = $params['sign'];
        $result = openssl_verify(self::getSignMd5($params), base64_decode($sign), $publicKeyId, OPENSSL_ALGO_SHA1);
        openssl_free_key($publicKeyId);
        if($result !== 1) {
            throw new Client\BadRequestException('签名无效');
        }
        return true;
    }


    /**
     * 根据参数计算未加密的签名
     *
     * @param array $params
     *
     * @return string
     */
    static function getSignMd5(array $params = [])
    {
        unset($params['sign'], $params['sign_method']);

        //过滤空变量
        $params = array_filter($params, function ($value) {
            return $value || is_numeric($value);
        });

        ksort($params);


        $signString = '';
        foreach ($params as $key => $value) {
            $signString .= $key . $value;
        }
        return md5($signString);
    }

}
