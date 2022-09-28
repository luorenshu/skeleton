<?php
/**
 * Create By PhpStorm
 * 作者 Bonjour<1051953562@qq.com>
 * 日期 2022/9/28
 * 时间 16:28
 */

namespace Core;


use Core\Helper\Code;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BaseResponse
 * @package Core
 */
class CoreResponse extends Response
{
    /**
     * 成功返回
     * @param array $data
     * @param string $message
     * @param int $code
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function successJson(array $data = [], string $message = '成功', int $code = Code::SUCCESS)
    {
        $format = [
            'success' => true,
            'message' => $message,
            'code'    => $code,
            'data'    => $data,
        ];
        return $this->getResponse()->withHeader('Server', 'Hyperf')
                    ->withAddedHeader('content-type', 'application/json; charset=utf-8')
                    ->withBody(new SwooleStream($this->toJson($format)));
    }

    /**
     * 失败返回
     * @param string $message
     * @param int $code
     * @param array $data
     * @return object|\Psr\Http\Message\ResponseInterface|null
     */
    public function errorJson(string $message = '失败', int $code = Code::ERROR, array $data = [])
    {
        $format = [
            'success' => false,
            'code'    => $code,
            'message' => $message,
        ];
        if (!empty($data)) {
            $format['data'] = &$data;
        }
        return $this->getResponse()->withHeader('Server', 'Hyperf')
                    ->withAddedHeader('content-type', 'application/json; charset=utf-8')
                    ->withBody(new SwooleStream($this->toJson($format)));
    }

    /**
     * 向浏览器输出图片
     * @param string $image
     * @param string $type
     * @return ResponseInterface
     */
    public function responseImage(string $image, string $type = 'image/png'): ResponseInterface
    {
        return $this->getResponse()->withHeader('Server', 'Hyperf')
                    ->withAddedHeader('content-type', $type)
                    ->withBody(new SwooleStream($image));
    }

}