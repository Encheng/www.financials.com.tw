<?php

namespace App\Services\NavItem;

use App\Models\Entities\Admin;
use App\Models\Entities\NavItem;
use App\Models\Repositories\NavItemRepository;
use Arr;
use Auth;
use Cache;
use Gate;
use Route;

class NavItemService
{
    use CacheTrait;

    private $navItemRepository;

    public function __construct(NavItemRepository $navItemRepository)
    {
        $this->redis = Cache::getRedis()
                            ->connection(config('cache.stores.redis.connection'));
        $this->navItemRepository = $navItemRepository;
    }

    /**
     * 透過上層選單id取得資料
     *
     * @param null|int $parentId
     * @param null|int $display
     *
     * @return array
     */
    public function getNavItemByParentId($parentId, $display = null)
    {
        $routeName = Route::currentRouteName();
        $gateAll = $this->getRouteNameIndexCache();
        $gateAll = array_flip($gateAll);
        $current = (object)$this->getNavItemCache($gateAll[$routeName]);

        /** @var Admin $admin */
        $admin = Auth::guard('admin')
                     ->user();

        $skipItem = function ($admin, $navItem) {
            if ($navItem->route_name != null) {
                if (!$this->checkRoutePermission($admin, $navItem->route_name)) {
                    return true;
                }
            } elseif (!$admin->hasRole($navItem->role)) {
                return true;
            }

            return false;
        };
        $arr = [];
        $navItems = $this->getNavItemsCache($parentId, $display);
        foreach ($navItems as $navItem) {
            /** @var NavItem $navItem */
            if ($skipItem($admin, $navItem)) {
                continue;
            }

            if (!empty($navItem->route_name) && !Route::has($navItem->route_name)) {
                $navItem->route_name = 'admin.index';
            }

            $navItem->active = false;
            if ($routeName == $navItem->route_name) {
                $navItem->active = true;
            } elseif (($current !== null) && ($current->active_nav_item_id == $navItem->id)) {
                $navItem->active = true;
            }

            $navItem->childs = [];
            $subNavItem = Arr::first($this->getNavItemsCache($navItem->id, $display));
            if ($subNavItem) {
                foreach ($this->getNavItemByParentId($navItem->id, $display) as $key => $child) {
                    if ($skipItem($admin, $child)) {
                        continue;
                    }
                    $navItem->childs[$key] = $child;
                }
            }
            $arr[$navItem->id] = $navItem;
        }

        return $arr;
    }

    /**
     * 檢查是否擁有指定route_name的權限
     *
     * @param Admin  $admin
     * @param String $routeName
     *
     * @return bool
     */
    private function checkRoutePermission(Admin $admin, string $routeName): bool
    {
        /** @var \Illuminate\Routing\Route|null $route */
        $route = Route::getRoutes()
                      ->getByName($routeName);
        if (!$route) {
            return false;
        }

        if (
            Gate::forUser($admin)
                ->none($admin->role, $route->getAction('controller'))
        ) {
            return false;
        }

        return true;
    }
}
