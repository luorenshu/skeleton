<?php
/**
 * Create By PhpStorm
 * 作者 Bonjour<1051953562@qq.com>
 * 日期 2022/9/28
 * 时间 16:25
 */

namespace Core\Traits;

use Core\Abstracts\AbstractMapper;
use Core\Annotation\Transaction;
use Core\CoreModel;
use Hyperf\Database\Model\Collection;
use Psr\Http\Message\ResponseInterface;

trait ServiceTrait
{
    /**
     * @var AbstractMapper
     */
    public AbstractMapper $mapper;

    /**
     * 获取列表数据
     * @param array|null $params
     * @param bool $isScope
     * @return array
     */
    public function getList(?array $params = null, bool $isScope = true): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        $params['recycle'] = false;
        return $this->mapper->getList($params, $isScope);
    }

    /**
     * 从回收站过去列表数据
     * @param array|null $params
     * @param bool $isScope
     * @return array
     */
    public function getListByRecycle(?array $params = null, bool $isScope = true): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        $params['recycle'] = true;
        return $this->mapper->getList($params, $isScope);
    }

    /**
     * 获取列表数据（带分页）
     * @param array|null $params
     * @param bool $isScope
     * @return array
     */
    public function getPageList(?array $params = null, bool $isScope = true): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        return $this->mapper->getPageList($params, $isScope);
    }

    /**
     * 从回收站获取列表数据（带分页）
     * @param array|null $params
     * @param bool $isScope
     * @return array
     */
    public function getPageListByRecycle(?array $params = null, bool $isScope = true): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        $params['recycle'] = true;
        return $this->mapper->getPageList($params, $isScope);
    }

    /**
     * 获取树列表
     * @param array|null $params
     * @param bool $isScope
     * @return array
     */
    public function getTreeList(?array $params = null, bool $isScope = true): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        $params['recycle'] = false;
        return $this->mapper->getTreeList($params, $isScope);
    }

    /**
     * 从回收站获取树列表
     * @param array|null $params
     * @param bool $isScope
     * @return array
     */
    public function getTreeListByRecycle(?array $params = null, bool $isScope = true): array
    {
        if ($params['select'] ?? null) {
            $params['select'] = explode(',', $params['select']);
        }
        $params['recycle'] = true;
        return $this->mapper->getTreeList($params, $isScope);
    }

    /**
     * 新增数据
     * @param array $data
     * @return int
     */
    public function save(array $data): int
    {
        return $this->mapper->save($data);
    }

    /**
     * 批量新增
     * @param array $collects
     * @return bool
     * @Transaction()
     */
    public function batchSave(array $collects): bool
    {
        foreach ($collects as $collect) {
            $this->mapper->save($collect);
        }
        return true;
    }

    /**
     * 读取一条数据
     * @param int $id
     * @return \Core\CoreModel|null
     */
    public function read(int $id): ?CoreModel
    {
        return $this->mapper->read($id);
    }

    /**
     * Description:获取单个值
     * User:mike
     * @param array $condition
     * @param string $columns
     * @return \Hyperf\Utils\HigherOrderTapProxy|mixed|void|null
     */
    public function value(array $condition, string $columns = 'id')
    {
        return $this->mapper->value($condition, $columns);
    }

    /**
     * Description:获取单列值
     * User:mike
     * @param array $condition
     * @param string $columns
     * @return array|null
     */
    public function pluck(array $condition, string $columns = 'id'): array
    {
        return $this->mapper->pluck($condition, $columns);
    }

    /**
     * 从回收站读取一条数据
     * @param int $id
     * @return \Core\CoreModel|null
     * @noinspection PhpUnused
     */
    public function readByRecycle(int $id): ?CoreModel
    {
        return $this->mapper->readByRecycle($id);
    }

    /**
     * 单个或批量软删除数据
     * @param array $ids
     * @return bool
     */
    public function delete(array $ids): bool
    {
        return !empty($ids) && $this->mapper->delete($ids);
    }

    /**
     * 更新一条数据
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return $this->mapper->update($id, $data);
    }

    /**
     * 按条件更新数据
     * @param array $condition
     * @param array $data
     * @return bool
     */
    public function updateByCondition(array $condition, array $data): bool
    {
        return $this->mapper->updateByCondition($condition, $data);
    }

    /**
     * 单个或批量真实删除数据
     * @param array $ids
     * @return bool
     */
    public function realDelete(array $ids): bool
    {
        return !empty($ids) && $this->mapper->realDelete($ids);
    }

    /**
     * 单个或批量从回收站恢复数据
     * @param array $ids
     * @return bool
     */
    public function recovery(array $ids): bool
    {
        return !empty($ids) && $this->mapper->recovery($ids);
    }

    /**
     * 单个或批量禁用数据
     * @param array $ids
     * @param string $field
     * @return bool
     */
    public function disable(array $ids, string $field = 'status'): bool
    {
        return !empty($ids) && $this->mapper->disable($ids, $field);
    }

    /**
     * 单个或批量启用数据
     * @param array $ids
     * @param string $field
     * @return bool
     */
    public function enable(array $ids, string $field = 'status'): bool
    {
        return !empty($ids) && $this->mapper->enable($ids, $field);
    }

    /**
     * 修改数据状态
     * @param int $id
     * @param string $value
     * @param string $filed
     * @return bool
     */
    public function changeStatus(int $id, string $value, string $filed = 'status'): bool
    {
        return $value == CoreModel::ENABLE ? $this->mapper->enable([ $id ], $filed) : $this->mapper->disable([ $id ], $filed);
    }

    /**
     * 数字更新操作
     * @param int $id
     * @param string $field
     * @param int $value
     * @return bool
     */
    public function numberOperation(int $id, string $field, int $value): bool
    {
        return $this->mapper->numberOperation($id, $field, $value);
    }

    /**
     * 数组数据转分页数据显示
     * @param array|null $params
     * @param string $pageName
     * @return array
     */
    public function getArrayToPageList(?array $params = [], string $pageName = 'page'): array
    {
        $collect = $this->handleArraySearch(collect($this->getArrayData($params)), $params);

        $pageSize = CoreModel::PAGE_SIZE;
        $page = 1;

        if ($params[$pageName] ?? false) {
            $page = (int) $params[$pageName];
        }

        if ($params['pageSize'] ?? false) {
            $pageSize = (int) $params['pageSize'];
        }

        $data = $collect->forPage($page, $pageSize)->toArray();

        return [
            'items' => $this->getCurrentArrayPageBefore($data, $params),
            'pageInfo' => [
                'total' => $collect->count(),
                'currentPage' => $page,
                'totalPage' => ceil($collect->count() / $pageSize)
            ]
        ];
    }

    /**
     * 数组数据搜索器
     * @param \Hyperf\Utils\Collection $collect
     * @param array $params
     * @return Collection
     */
    protected function handleArraySearch(\Hyperf\Utils\Collection $collect, array $params): \Hyperf\Utils\Collection
    {
        return $collect;
    }

    /**
     * 数组当前页数据返回之前处理器，默认对key重置
     * @param array $data
     * @param array $params
     * @return array
     */
    protected function getCurrentArrayPageBefore(array &$data, array $params = []): array
    {
        sort($data);
        return $data;
    }

    /**
     * 设置需要分页的数组数据
     * @param array $params
     * @return array
     */
    protected function getArrayData(array $params = []): array
    {
        return [];
    }
}
