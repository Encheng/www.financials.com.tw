<?php

namespace App\Models\Presenters;

use App\Models\Entities\Admin;
use App\Models\Entities\Role;
use Illuminate\Database\Eloquent\Model;

class AdminPresenter extends Presenter
{
    use FormDataTrait;

    /**
     * 取得狀態清單
     *
     * @return array
     */
    public function getStatusList()
    {
        return [
            Admin::STATUS_DISABLE => '停用',
            Admin::STATUS_ENABLE => '啟用',
        ];
    }

    /**
     * 取得用戶的權限名稱
     *
     * @return array
     */
    public function getRolesDisplayName()
    {
        /** @var Admin $model */
        $model = $this->entity;

        return array_values(\Arr::only(Role::list(), $model->role));
    }

    /**
     * 檢查帳號是否已選取權限群組
     *
     * @param string     $column
     * @param int|string $optionVal
     *
     * @return bool
     */
    public function getRoleSelected($column, $optionVal)
    {
        /** @var Model $model */
        $model = $this->entity;
        $old = old($column, null);
        if ($old !== null) {
            if (is_array($old)) {
                return in_array($optionVal, $old) ? true : false;
            }

            return ($optionVal == $old) ? true : false;
        }

        if (in_array($optionVal, $model->role)) {
            return true;
        }

        return false;
    }

    /**
     * 檢查是否可編輯
     *
     * @return bool
     */
    public function checkCanEdit()
    {
        return ($this->entity->protected === Admin::PROTECTED_FALSE) ? true : false;
    }
}
