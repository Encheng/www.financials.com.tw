<?php

namespace Database\Seeders\Admin;

use App\Models\Entities\NavItem;
use App\Models\Entities\Role;
use App\Models\Repositories\NavItemRepository;
use Illuminate\Database\Seeder;

class AdminNavItemSeeder extends Seeder
{

    private $navItemRepository;
    private $columns = [
        'parent_id',
        'name',
        'route_name',
        'role',
        'active_nav_item_id',
        'icon',
        'display',
    ];

    public function __construct(NavItemRepository $navItemRepository)
    {
        $this->navItemRepository = $navItemRepository;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 取得根目錄
        $rootId = $this->navItemRepository->getIdByParentId(null, ['route_name' => 'admin.index', 'display' => false]);

        $data = [
            [
                'parent_id' => $rootId,
                'name' => '帳號管理',
                'route_name' => null,
                'role' => Role::ADMIN,
                'active_nav_item_id' => null,
                'icon' => 'fa fa-folder',
                'display' => NavItem::DISPLAY_SHOW,
                'child' => [
                    [
                        'name' => '帳號列表',
                        'route_name' => 'admin.accounts.index',
                        'icon' => 'fa fa-list',
                        'display' => NavItem::DISPLAY_SHOW,
                    ],
                    [
                        'name' => '帳號新增',
                        'route_name' => 'admin.accounts.create',
                        'icon' => 'fa fa-plus',
                        'display' => NavItem::DISPLAY_SHOW,
                    ],
                    [
                        'name' => '帳號編輯',
                        'route_name' => 'admin.accounts.edit',
                        'display' => NavItem::DISPLAY_HIDDEN,
                        'active_root' => true,
                    ],
                ]
            ],
        ];

        foreach ($data as $datum) {
            $model = new NavItem();
            $model->fill($this->getModelData($datum))
                  ->save();
            if (isset($datum['child'])) {
                foreach ($datum['child'] as $childDatum) {
                    $child = new NavItem();
                    $append = ['parent_id' => $model->id];
                    if (isset($childDatum['active_root']) && $childDatum['active_root']) {
                        $append = array_merge($append, ['active_nav_item_id' => $model->id]);
                    }
                    $child->fill($this->getModelData($childDatum + $append))
                          ->save();
                }
            }
        }
    }

    private function getModelData($arr)
    {
        return \Arr::only($arr, $this->columns);
    }
}
