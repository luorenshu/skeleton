<?php
/**
 * Create By PhpStorm
 * 作者 Bonjour<1051953562@qq.com>
 * 日期 2022/9/28
 * 时间 17:04
 */

namespace Core\Aspect;


use Core\Annotation\Transaction;
use Core\Exception\CoreException;
use Core\Helper\Code;
use Hyperf\DbConnection\Db;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;

/**
 * 事务注解切面
 * Class TransactionAspect
 * @package Core\Aspect
 * @Aspect()
 */
class TransactionAspect extends AbstractAspect
{
    /**
     * @var string[]
     */
    public $annotations = [
        Transaction::class
    ];

    /**
     * @param \Hyperf\Di\Aop\ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        /** @var Transaction $transaction */
        if (isset($proceedingJoinPoint->getAnnotationMetadata()->method[Transaction::class])) {
            $transaction = $proceedingJoinPoint->getAnnotationMetadata()->method[Transaction::class];
        }
        try {
            Db::beginTransaction();
            $number = 0;
            $retry = intval($transaction->retry);
            do {
                $result = $proceedingJoinPoint->process();
                if (!is_null($result)) {
                    break;
                }
                ++$number;
            } while ($number < $retry);
            Db::commit();
        } catch (\Throwable $e) {
            Db::rollBack();
            throw new CoreException($e->getMessage(), Code::ERROR);
        }
        return $result;
    }
}