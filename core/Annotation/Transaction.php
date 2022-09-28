<?php
/**
 * Create By PhpStorm
 * 作者 Bonjour<1051953562@qq.com>
 * 日期 2022/9/28
 * 时间 17:01
 */

namespace Core\Annotation;


use Doctrine\Common\Annotations\Annotation\Target;
use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * 数据库事务注解
 * Class Transaction
 * @package Core\Annotation
 * @Annotation
 * @Target({"METHOD"})
 */
class Transaction extends AbstractAnnotation
{
    /**
     * retry 重试次数
     * @var int
     */
    public int $retry = 1;

    public function __construct($value = 1)
    {
        parent::__construct($value);
        $this->bindMainProperty('retry', [$value]);
    }

}