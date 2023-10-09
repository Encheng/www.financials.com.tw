<?php

namespace App\Http\Composers;

use App\Models\Entities\NavItem;
use App\Models\Repositories\NavItemRepository;
use App\Services\NavItem\NavItemService;
use Illuminate\View\View;

class SideBarComposer
{
    public function compose(View $view)
    {
        $navItemRepository = app(NavItemRepository::class);
        $navItemService = app(NavItemService::class);
        $root = $navItemRepository->getByParentId(null);
        $navItems = $navItemService->getNavItemByParentId($root->first()->id, NavItem::DISPLAY_SHOW);

        $view->with(['sideBarNavItems' => $navItems,]);
    }
}
