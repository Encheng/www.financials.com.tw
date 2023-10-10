<?php

namespace Database\Seeders\Admin;

use App\Models\Entities\NavItem;
use App\Models\Entities\Role;
use App\Models\Repositories\NavItemRepository;
use Illuminate\Database\Seeder;

class CompanyNavItemSeeder extends Seeder
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
                'name' => '公司管理',
                'route_name' => null,
                'role' => Role::ADMIN,
                'active_nav_item_id' => null,
                'icon' => 'fa fa-folder',
                'display' => NavItem::DISPLAY_SHOW,
                'child' => [
                    [
                        'name' => '公司列表',
                        'route_name' => 'admin.company.index',
                        'icon' => 'fa fa-list',
                        'display' => NavItem::DISPLAY_SHOW,
                    ],
                    [
                        'name' => '公司新增',
                        'route_name' => 'admin.company.create',
                        'icon' => 'fa fa-plus',
                        'display' => NavItem::DISPLAY_SHOW,
                    ],
                    [
                        'name' => '公司新增儲存',
                        'route_name' => 'admin.company.store',
                        'display' => NavItem::DISPLAY_HIDDEN,
                        'active_root' => true,
                    ],
                    [
                        'name' => '公司編輯',
                        'route_name' => 'admin.company.edit',
                        'display' => NavItem::DISPLAY_HIDDEN,
                        'active_root' => true,
                    ],
                    [
                        'name' => '公司編輯儲存',
                        'route_name' => 'admin.company.update',
                        'display' => NavItem::DISPLAY_HIDDEN,
                        'active_root' => true,
                    ],
                    [
                        'name' => '公司財報分析',
                        'route_name' => 'admin.company.analyze',
                        'display' => NavItem::DISPLAY_HIDDEN,
                        'active_root' => true,
                    ],
                    [
                        'name' => '公司財報新增',
                        'route_name' => 'admin.company.financial.create',
                        'display' => NavItem::DISPLAY_HIDDEN,
                        'active_root' => true,
                    ],
                    [
                        'name' => '公司財報新增儲存',
                        'route_name' => 'admin.company.financial.store',
                        'display' => NavItem::DISPLAY_HIDDEN,
                        'active_root' => true,
                    ],
                    [
                        'name' => '公司財報批次匯入',
                        'route_name' => 'admin.company.financial.import',
                        'icon' => 'fa fa-plus',
                        'display' => NavItem::DISPLAY_SHOW,
                    ],
                    [
                        'name' => '公司財報批次匯入執行',
                        'route_name' => 'admin.company.financial.import.process',
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
