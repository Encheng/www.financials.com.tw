<?php

namespace App\Models\Repositories;

use App\Models\Entities\NavItem;
use Illuminate\Database\Eloquent\Collection;

class NavItemRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new NavItem();
    }

    /**
     * 透過parent_id取得nav_item id
     *
     * @param int|null $parentId
     * @param array    $condition
     *
     * @return mixed
     */
    public function getIdByParentId($parentId, $condition = [])
    {
        return $this->model->where('parent_id', $parentId)
                           ->basicWhere(['display', 'route_name'], $condition)
                           ->value('id');
    }

    /**
     * 透過parent_id取得資料
     *
     * @param int          $parentId
     * @param string|array $columns
     * @param array        $condition
     *
     * @return Collection
     */
    public function getByParentId($parentId, $columns = '*', $condition = [])
    {
        return $this->model->select($columns)
                           ->where('parent_id', $parentId)
                           ->basicWhere(['display'], $condition)
                           ->get();
    }
}
