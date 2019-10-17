<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException as IlluminateAuthorizationException;
use Illuminate\Auth\AuthenticationException as IlluminateAuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException as IlluminateValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Urland\Api\Http\ApiResponse;
use Urland\Exceptions\BaseException as UrlandBaseException;
use Urland\Exceptions\Client as UrlandClient;
use Urland\Exceptions\Server as UrlandServer;
use UTMS\Exceptions\Account\NotEnoughBalanceException;

class ApiHandler implements ExceptionHandlerContract
{
    /**
     * The container implementation.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * A list of the internal exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        HttpResponseException::class,
        IlluminateAuthenticationException::class,
        IlluminateAuthorizationException::class,
        IlluminateValidationException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        UrlandClient\AuthenticationException::class,
        UrlandClient\ValidationException::class,
        UrlandClient\NotFoundException::class,
    ];

    /**
     * The list should report as debug.
     *
     * @var array
     */
    protected $reportAsDebug = [
        UrlandClient\BaseException::class,
        UrlandClient\BadRequestException::class,
        UrlandClient\ForbiddenException::class,
        NotEnoughBalanceException::class,
    ];

    /**
     * Create a new exception handler instance.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     *
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     *
     * @throws \Exception
     */
    public function report(\Exception $exception)
    {
        if ($this->shouldntReport($exception)) {
            return;
        }

        try {
            $logger = $this->container->make(LoggerInterface::class);
        } catch (\Exception $ex) {
            throw $exception; // throw the original exception
        }

        if ($this->shouldReportAsDebug($exception)) {
            $logger->debug($exception->getMessage(),
                ['exception' => $exception]);
        } else {
            $logger->error(
                $exception->getMessage(),
                ['exception' => $exception]
            );
        }
    }

    /**
     * Determine if the exception is in the "do not report" list.
     *
     * @param \Exception $e
     *
     * @return bool
     */
    protected function shouldntReport(\Exception $e)
    {
        return !is_null(Arr::first($this->dontReport, function ($type) use ($e) {
            return $e instanceof $type;
        }));
    }

    /**
     * Determine if the exception is in the "report as debug" list.
     *
     * @param \Exception $e
     *
     * @return bool
     */
    protected function shouldReportAsDebug(\Exception $e)
    {
        return !is_null(Arr::first($this->reportAsDebug, function ($type) use ($e) {
            return $e instanceof $type;
        }));
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception               $exception
     *
     * @return ApiResponse
     */
    public function render($request, \Exception $exception)
    {
        $exception = $this->prepareException($exception);

        return $this->prepareResponse($exception);
    }

    /**
     * Render an exception to the console.
     *
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param \Exception                                        $exception
     *
     * @return void
     */
    public function renderForConsole($output, \Exception $exception)
    {
        (new ConsoleApplication)->renderException($exception, $output);
    }

    /**
     * 异常转换成Api用的异常
     *
     * @param \Exception $exception
     *
     * @return UrlandBaseException
     */
    protected function prepareException(\Exception $exception)
    {
        // 如果异常属于基础异常，直接返回
        if ($exception instanceof UrlandBaseException) {
            return $exception;
        }

        if ($exception instanceof ModelNotFoundException) {
            // 资源不存在
            try {
                $modelClass = $exception->getModel();
                $modelName  = $modelClass::MODEL_NAME;
                $message    = ($modelName ?: '资源') . '不存在';
            } catch (\Exception $e) {
                $message = '资源不存在';
            }
            $exception = new UrlandClient\NotFoundException($message, $exception);
        } else if ($exception instanceof IlluminateValidationException) {
            // 表单验证失败
            $exception = new UrlandClient\ValidationException($exception->validator, $exception);
        } else if ($exception instanceof IlluminateAuthenticationException) {
            // 登录失败
            $exception = new UrlandClient\AuthenticationException('请先登录', $exception);
        } else if ($exception instanceof IlluminateAuthorizationException || $exception instanceof AccessDeniedHttpException) {
            // 已登录但权限不够
            $exception = new UrlandClient\ForbiddenException('权限不足', $exception);
        } else if ($exception instanceof HttpException) {
            // 手动生成的HttpException，根据statusCode区别处理
            switch ($exception->getStatusCode()) {
                case 429: // 接口访问频率限制
                    $exception = new UrlandClient\TooManyRequestsException('访问过于频繁', $exception,
                        $exception->getHeaders());
                    break;

                default:
                    break;

            }
        }

        return $exception;
    }

    /**
     * 异常转成响应
     *
     * @param \Exception $exception
     *
     * @return ApiResponse
     */
    protected function prepareResponse(\Exception $exception)
    {
        if (!$exception instanceof UrlandBaseException) {
            $exception = new UrlandServer\InternalServerException();
        }

        $data = ['message' => $exception->getMessage()];
        if ($exception instanceof UrlandClient\ValidationException) {
            $data['errors'] = $exception->errors();
        }

        return new ApiResponse($data, $exception->getStatusCode(), $exception->getHeaders());
    }

    /**
     * Determine if the exception should be reported.
     *
     * @param \Exception $e
     *
     * @return bool
     */
    public function shouldReport(Exception $e)
    {
        return !$this->shouldntReport($e);
    }
}
