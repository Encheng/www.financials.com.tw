<?php

namespace Database\Seeders\Admin;

use App\Models\Entities\NavItem;
use App\Models\Entities\Role;
use Illuminate\Database\Seeder;

class NavItemSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'parent_id' => null,
            'name' => '管理區首頁',
            'route_name' => 'admin.index',
            'role' => array_keys(Role::list()),
            'active_nav_item_id' => null,
            'icon' => null,
            'display' => NavItem::DISPLAY_HIDDEN,
        ];
        $model = new NavItem();
        $model->fill($data)
              ->save();
    }
}
