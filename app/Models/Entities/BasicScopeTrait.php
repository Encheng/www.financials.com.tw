<?php

namespace App\Models\Entities;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

trait BasicScopeTrait
{
    /**
     * 基本欄位查詢
     *
     * @param Builder      $query
     * @param array|string $columns   欄位名稱, ['id', 'title'] OR 'name'
     * @param array        $condition 搜尋條件, ['id'=>1, 'title'=>'taipei']
     *
     * @return Builder
     */
    public function scopeBasicWhere($query, $columns, $condition = [])
    {
        $columns = !is_array($columns) ? [$columns] : $columns;

        /** @var Builder $query */
        foreach ($columns as $column) {
            if (
                array_key_exists($column, $condition) &&
                ($condition[$column] !== '') &&
                ($condition[$column] !== null)
            ) {
                $query->where($column, $condition[$column]);
            }
        }

        return $query;
    }

    /**
     * 基本表單欄位排序, ['id'=>'ASC', 'sort'=>'DESC']
     *
     * @param Builder $query
     * @param array   $order
     * @param string  $alias
     *
     * @return Builder
     */
    public function scopeBasicOrder($query, $order, $alias = '')
    {
        foreach ($order as $column => $rule) {
            $query->orderBy((!empty($alias)) ? "{$alias}.$column" : $column, $order[$column]);
        }

        return $query;
    }

    /**
     * 基本取分頁或Collection功能，若perPage設定為0則返回collection
     *
     * @param Builder $query
     * @param int     $perPage
     *
     * @return LengthAwarePaginator|Collection
     */
    public function scopeBasicPaginate($query, $perPage = 15)
    {
        return ($perPage > 0) ? $query->paginate($perPage) : $query->get();
    }
}
