<?php
/**
 * Create By PhpStorm
 * 作者 Bonjour<1051953562@qq.com>
 * 日期 2022/9/28
 * 时间 17:32
 */

namespace Core\Exception\Handler;


use Core\Helper\Code;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{

    /**
     * @param \Throwable $throwable
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $format = ['success' => false, 'code' => 500, 'message' => $throwable->getMessage()];
        return $response->withHeader('Server', 'Hyperf')
                        ->withAddedHeader('content-type', 'application/json; charset=utf-8')
                        ->withStatus(Code::ERROR)->withBody(new SwooleStream(Json::encode($format)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}