<?php
/**
 * Create By PhpStorm
 * 作者 Bonjour<1051953562@qq.com>
 * 日期 2022/9/28
 * 时间 16:27
 */

namespace Core;


use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Request;

/**
 * Class BaseRequest
 * @package Core
 */
class CoreRequest extends Request
{

    /**
     * @var CoreResponse
     * @Inject()
     */
    protected CoreResponse $response;

    /**
     * 获取请求ip
     * @return string
     */
    public function ip(): string
    {
        $ip = $this->getServerParams()['remote_addr'] ?? '0.0.0.0';
        $headers = $this->getHeaders();

        if (isset($headers['x-real-ip'])) {
            $ip = $headers['x-real-ip'][0];
        } else {
            if (isset($headers['x-forwarded-for'])) {
                $ip = $headers['x-forwarded-for'][0];
            } else {
                if (isset($headers['http_x_forwarded_for'])) {
                    $ip = $headers['http_x_forwarded_for'][0];
                }
            }
        }

        return $ip;
    }

}