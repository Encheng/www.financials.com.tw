<?php

namespace App\Models\Presenters;

use Illuminate\Database\Eloquent\Model;

/**
 * Trait FormDataTrait
 * 引用的class必需繼承 \Laracasts\Presenter\Presenter
 *
 * @package App\Traits\Presenters
 */
trait FormDataTrait
{
    /**
     * 取得表單欄位資料
     *
     * @param string $column
     *
     * @return mixed
     */
    public function getFormValue($column)
    {
        return old($column, data_get($this->entity, $column));
    }

    /**
     * 取得表單選取的資料
     * 若有old input以舊資料為優先顯示項目
     *
     * @param string $column
     * @param string $optionVal
     *
     * @return bool
     */
    public function getFormSelected($column, $optionVal)
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

        return (isset($model->{$column}) && ($model->{$column} == $optionVal)) ? true : false;
    }
}
