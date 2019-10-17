<?php

namespace App\Http\Controllers\CommonApi\OSS;

use App\Http\Controllers\CommonApi\BaseController;
use App\Http\Resources\CommonApi\OSS\TokenResource;
use App\Services\OSS\OSSService;

/**
 * 文件服务器接口
 *
 * Class OSSController
 *
 * @package App\Http\Controllers\CommonApi\OSS
 */
class OSSController extends BaseController
{
    /**
     * 获取图片Token
     *
     * @return \App\Http\Resources\CommonApi\OSS\TokenResource
     * @throws \InvalidArgumentException
     * @throws \Urland\Exceptions\Server\InternalServerException
     */
    public function storeImageToken()
    {
        return new TokenResource((new OSSService())->getNewImageToken());
    }

    /**
     * 获取文件Token
     *
     * @return \App\Http\Resources\CommonApi\OSS\TokenResource
     * @throws \InvalidArgumentException
     * @throws \Urland\Exceptions\Server\InternalServerException
     */
    public function storeFileToken()
    {
        return new TokenResource((new OSSService())->getNewFileToken());
    }
}