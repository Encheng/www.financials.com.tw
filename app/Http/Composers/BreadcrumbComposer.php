<?php

namespace App\Http\Composers;

use App\Models\Entities\NavItem;
use App\Services\NavItem\NavItemService;
use Cache;
use DB;
use Illuminate\View\View;

class BreadcrumbComposer
{
    public function compose(View $view)
    {
        $currentRouteName = \Route::currentRouteName();

        $navItemService = app(NavItemService::class);
        $gateAll = $navItemService->getRouteNameIndexCache();
        $gateAll = array_flip($gateAll);
        // 檢查選單是否存在
        if (!isset($gateAll[$currentRouteName])) {
            $view->with(['breadcrumbCollect' => []]);

            return;
        }

        // 取得id
        $navItemId = $gateAll[$currentRouteName];

        $key = "nav_items:{$navItemId}:breadcrumb";
        $breadcrumb = Cache::remember($key, 6 * 60 * 60, function () use ($navItemId) {
            // 由當前選單位置向上查詢(parent)
            $source = DB::raw('(' . NavItem::orderBy('id', 'DESC')
                                           ->toSql() . ') AS t');

            return DB::table($source)
                     ->join(DB::raw('(SELECT @pv:=' . $navItemId . ') AS tmp'), function ($query) {
                     })
                     ->selectRaw('`t`.`id`, `t`.`name`, @pv:=`t`.`parent_id` AS `parent_id`')
                     ->whereRaw('`t`.`id`=@pv')
                     ->get()
                     ->reverse()
                     ->toArray();
        });

        $view->with(['breadcrumbCollect' => $breadcrumb]);
    }
}
