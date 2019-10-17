<?php

namespace UTMS\Pay56;


use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Arr;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use Urland\ApiClient\Response\Response;
use Urland\Exceptions\Client as UrlandClient;
use Urland\Exceptions\Server as UrlandServer;


/**
 * 56PAY支付服务 接口类
 *
 * Class Pay56Client
 *
 * @package UTMS\Pay56
 *
 * @method Response get(string | UriInterface $uri, array $data = [], array $options = [])
 * @method Response head(string | UriInterface $uri, array $data = [], array $options = [])
 * @method Response put(string | UriInterface $uri, array $data = [], array $options = [])
 * @method Response post(string | UriInterface $uri, array $data = [], array $options = [])
 * @method Response patch(string | UriInterface $uri, array $data = [], array $options = [])
 * @method Response delete(string | UriInterface $uri, array $data = [], array $options = [])
 */
class Pay56Client
{

    /**
     * The api services.
     *
     * @var array
     */
    static protected $services;

    /**
     * @var GuzzleClient
     */
    protected $client;

    /**
     * The api service configurations.
     *
     * @var array
     */
    protected $config;

    protected $api_key;
    protected $api_secret_file;
    protected $pay56_public_file;

    public $options;

    /**
     * Client constructor.
     *
     * @param array $config
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($config)
    {
        $this->config = $config;

        $this->api_key           = Arr::get($config, 'api_key');
        $this->api_secret_file   = Arr::get($config, 'api_secret_file');
        $this->pay56_public_file = Arr::get($config, 'pay56_public_file');

        $this->client = new GuzzleClient($config);
    }

    /**
     * 格式化响应
     *
     * @param ResponseInterface $response
     *
     * @return Response
     */
    protected function formatResponse(ResponseInterface $response)
    {
        return Response::create($response);
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return Response
     * @throws RequestException
     * @throws \InvalidArgumentException
     * @throws \Urland\Exceptions\BaseException
     */
    public function __call($name, $arguments)
    {
        if (count($arguments) < 1) {
            throw new \InvalidArgumentException('Magic request methods require a URI and optional data array');
        }

        $uri     = isset($arguments[0]) ? $arguments[0] : '';
        $data    = isset($arguments[1]) ? $arguments[1] : [];
        $options = isset($arguments[2]) ? $arguments[2] : [];

        $data = Sign::build($data, $this->api_key, $this->api_secret_file);
        try {
            switch ($name) {
                case 'get' :
                    $response = $this->client->$name($uri, array_merge($options, ['query' => $data]));
                    break;
                case 'post':
                case 'put':
                case 'patch':
                case 'delete':
                    $response = $this->client->$name($uri, array_merge($options, ['form_params' => $data]));
                    break;
                default :
                    throw new UrlandServer\InternalServerException($name . '不存在');
            }
        } catch (RequestException $exception) {
            // 转换成悠然居通用异常
            if ($urlandException = $this->transformToUrlandException($exception)) {
                throw $urlandException;
            }

            throw $exception;
        }

        return $this->formatResponse($response);
    }

    /**
     * 转换成悠然居通用异常
     *
     * @param \GuzzleHttp\Exception\RequestException $exception
     *
     * @return \Urland\Exceptions\BaseException|null
     */
    protected function transformToUrlandException($exception)
    {
        // 判断是否存在悠然居的基类
        if (!$exception instanceof RequestException || !class_exists(\Urland\Exceptions\BaseException::class)) {
            return null;
        }

        // 判断是否存在响应，不存在响应证明不属于网络请求后的操作
        if (!$exception->getResponse()) {
            return null;
        }

        $response = $this->formatResponse($exception->getResponse());
        try {
            $jsonData = $response->getJson();
        } catch (\Throwable $e) {
            $jsonData = [];
        }

        $newException = null;
        $message      = isset($jsonData['message']) ? $jsonData['message'] : null;
        switch ($response->getStatusCode()) {
            case 400:
                $newException = new UrlandClient\BadRequestException($message, $exception);
                break;

            case 401:
                $newException = new UrlandClient\AuthenticationException($message, $exception);
                break;

            case 403:
                $newException = new UrlandClient\ForbiddenException($message, $exception);
                break;

            case 404:
                $newException = new UrlandClient\NotFoundException($message, $exception);
                break;

            case 422:
                $errors = isset($jsonData['errors']) ? $jsonData['errors'] : [];
                if (class_exists(\Illuminate\Support\Facades\Validator::class)) {
                    // laravel环境
                    $newException = UrlandClient\ValidationException::withMessages($errors);
                } else {
                    // 非laravel环境
                    $firstErrors = (array)reset($errors);
                    $firstError  = reset($firstErrors);

                    $newException = new UrlandClient\BaseException(422, $firstError ?: $message, $exception);
                }
                break;

            case 429:
                $newException = new UrlandClient\TooManyRequestsException($message, $exception);
                break;

            case 500:
                $newException = new UrlandServer\InternalServerException($message, $exception);
                break;

            case 503:
                $newException = new UrlandServer\ServiceUnavailableException($message, $exception);
        }

        return $newException;
    }

    /**
     * 签名验证
     *
     * @param array $params
     *
     * @return bool
     * @throws \Urland\Exceptions\Client\BadRequestException
     */
    public function callbackSigVerif($params)
    {
        return Sign::sigVerif($params, $this->pay56_public_file);
    }
}
