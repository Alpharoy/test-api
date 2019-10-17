<?php

namespace App\Services\OSS;

use App\Services\BaseService;
use Illuminate\Support\Arr;
use Urland\Exceptions\Server\InternalServerException;

class OSSService extends BaseService
{
    /**
     * 获取OSS图片上传token
     *
     * @return string
     * @throws \InvalidArgumentException
     * @throws \Urland\Exceptions\Server\InternalServerException
     */
    public function getNewImageToken()
    {
        $result = oss_client()->post('image/token')->getJson();
        $token  = Arr::get($result, 'access_token');
        if (empty($token)) {
            throw new InternalServerException('获取图片上传token失败');
        }

        return $token;
    }

    /**
     * 获取OSS文件上传token
     *
     * @return string
     * @throws \InvalidArgumentException
     * @throws \Urland\Exceptions\Server\InternalServerException
     */
    public function getNewFileToken()
    {
        $result = oss_client()->post('file/token')->getJson();
        $token  = Arr::get($result, 'access_token');
        if (empty($token)) {
            throw new InternalServerException('获取文件上传token失败');
        }

        return $token;
    }

    /**
     * 单文件上传
     *
     * @param string                                            $name
     * @param string|resource|\Psr\Http\Message\StreamInterface $file
     * @param null                                              $expireMinutes
     *
     * @return array|null
     */
    public function uploadFile(string $name, $file, $expireMinutes = null)
    {
        $result = $this->uploadFiles([$name => $file], $expireMinutes);
        return Arr::first($result);
    }

    /**
     * 多文件上传
     *
     * @param array    $files
     * @param null|int $expireMinutes
     *
     * @return array|null
     * @throws \InvalidArgumentException
     * @throws \Urland\Exceptions\Server\InternalServerException
     */
    public function uploadFiles(array $files, $expireMinutes = null)
    {
        $token = $this->getNewFileToken();
        if (is_null($expireMinutes)) {
            $expireMinutes = 30 * 24 * 60;
        }

        $multipart = [
            [
                'name'     => 'access_token',
                'contents' => $token,
            ],
            [
                'name'     => 'expiry_time',
                'contents' => $expireMinutes,
            ],
        ];

        // 追加文件
        foreach ($files as $name => $file) {
            $multipart[] = [
                'name'     => 'files[]',
                'contents' => $file,
                'filename' => $name,
            ];
        }

        return oss_public_client()->post('files', [], ['multipart' => $multipart])->getJson();
    }
}