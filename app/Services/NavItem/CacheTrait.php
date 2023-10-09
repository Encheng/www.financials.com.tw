<?php

namespace App\Services\NavItem;

use App\Models\Entities\NavItem;
use App\Models\Repositories\NavItemRepository;
use Cache;

/**
 * Trait CacheTrait
 *
 * @package App\Services\NavItem
 *
 * @property \Redis            $redis
 * @property NavItemRepository $navItemRepository
 */
trait CacheTrait
{
    private $redis;

    /**
     * 取得nav_item快取資料
     *
     * @param int $id
     *
     * @return object|null
     */
    public function getNavItemCache($id)
    {
        $key = self::getCacheKey("nav_items:{$id}:model");
        if ($this->redis->exists($key) == 1) {
            return (object)$this->redis->hGetAll($key);
        }

        $model = NavItem::where('id', $id)
                        ->first();
        if ($model === null) {
            return null;
        }
        $data = $model->toArray();
        $this->redis->hMSet($key, $data);
        // 快取為期6小時; nav_item除非新增功能，不太會進行異動
        $this->redis->expire($key, 6 * 60 * 60);

        return (object)$data;
    }

    /**
     * 取得nav items快取
     *
     * @param string $parentId
     * @param int    $display
     *
     * @return array
     */
    public function getNavItemsCache($parentId, $display)
    {
        $key = "nav_items:parent:{$parentId}:display:{$display}:child";

        $cached = Cache::remember($key, rand(1, 3) * 60 * 60, function () use ($parentId, $display) {
            $columns = [
                'id',
                'parent_id',
                'active_nav_item_id',
                'name',
                'route_name',
                'role',
                'icon',
                'display',
            ];
            $condition = ['display' => $display];

            return $this->navItemRepository->getByParentId($parentId, $columns, $condition)
                                           ->toJson();
        });

        return json_decode($cached);
    }

    /**
     * 取得授權索引快取資料
     *
     * @return array
     */
    public function getRouteNameIndexCache()
    {
        $key = self::getCacheKey('nav_items:gates:index');
        if ($this->redis->exists($key) == 1) {
            return $this->redis->hGetAll($key);
        }

        $navItems = NavItem::select(['id', 'route_name'])
                           ->where('route_name', '!=', null)
                           ->get();
        $navItemIndex = $navItems->pluck('route_name', 'id')
                                 ->toArray();
        $this->redis->hMSet($key, $navItemIndex);
        // 快取為期6小時; nav_item除非新增功能，不太會進行異動
        $this->redis->expire($key, 6 * 60 * 60);

        return $navItemIndex;
    }

    /**
     * 刪除nav_items的所有快取
     *
     * @return int
     */
    public function deleteAllNavItemsCache()
    {
        $keys = $this->redis->keys(Cache::getPrefix() . 'nav_items:*');
        $prefix = config('database.redis.options.prefix');

        return $this->redis->del(array_map(function ($val) use ($prefix) {
            return str_replace($prefix, '', $val);
        }, $keys));
    }

    protected static function getCacheKey($append)
    {
        return Cache::getPrefix() . $append;
    }
}
