<?php
/**
 * Create By PhpStorm
 * 作者 Bonjour<1051953562@qq.com>
 * 日期 2022/9/28
 * 时间 16:25
 */

namespace Core\Traits;


use Core\CoreRequest;
use Core\CoreResponse;
use Core\Helper\Code;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;

/**
 * Trait ControllerTrait
 * @package Core\Traits
 */
trait ControllerTrait
{
    /**
     * @Inject()
     * @var CoreRequest
     */
    protected CoreRequest $request;

    /**
     * @Inject()
     * @var CoreResponse
     */
    protected CoreResponse $response;

    /**
     * 成功返回
     * @param array $data
     * @param string $message
     * @param int $code
     * @return mixed
     */
    public function successJson(array $data = [], string $message = '成功', int $code = Code::SUCCESS)
    {
        return $this->successJson($data, $message, $code);
    }

    /**
     * 失败返回
     * @param string $message
     * @param int $code
     * @param array $data
     * @return mixed
     */
    public function errorJson(string $message = '失败', int $code = Code::ERROR, array $data = [])
    {
        return $this->errorJson($message, $code, $data);
    }

    /**
     * 重定向
     * @param string $toUrl
     * @param int $status
     * @param string $schema
     * @return ResponseInterface
     */
    public function redirect(string $toUrl, int $status = 302, string $schema = 'http'): ResponseInterface
    {
        return $this->response->redirect($toUrl, $status, $schema);
    }

    /**
     * 下载文件
     * @param string $filePath
     * @param string $name
     * @return ResponseInterface
     */
    public function _download(string $filePath, string $name = ''): ResponseInterface
    {
        return $this->response->download($filePath, $name);
    }

}