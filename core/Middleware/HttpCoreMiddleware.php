<?php
/**
 * Create By PhpStorm
 * 作者 Bonjour<1051953562@qq.com>
 * 日期 2022/9/28
 * 时间 15:10
 */

namespace Core\Middleware;


use Core\Helper\Code;
use Hyperf\HttpServer\CoreMiddleware;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class HttpCoreMiddleware
 * @package Core\Middleware
 */
class HttpCoreMiddleware extends CoreMiddleware
{
    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function handleNotFound(ServerRequestInterface $request): ResponseInterface
    {
        $format = [
            'success' => false,
            'code'    => Code::NOT_FOUND,
            'message' => '您访问的资源不存在'
        ];
        return $this->response()->withHeader('Server', 'Hyperf')
                    ->withAddedHeader('content-type', 'application/json; charset=utf-8')
                    ->withStatus(404)
                    ->withBody(new SwooleStream(Json::encode($format)));
    }

    /**
     * @param array $methods
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function handleMethodNotAllowed(array $methods, ServerRequestInterface $request): ResponseInterface
    {
        $format = [
            'success' => false,
            'code'    => Code::METHOD_NOT_ALLOW,
            'message' => '请求方式错误'
        ];
        return $this->response()->withHeader('Server', 'Hyperf')
                    ->withAddedHeader('content-type', 'application/json; charset=utf-8')
                    ->withStatus(405)
                    ->withBody(new SwooleStream(Json::encode($format)));
    }
}