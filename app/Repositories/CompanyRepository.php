<?php

namespace App\Repositories;

use App\Models\Entities\Company;

class CompanyRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new Company();
    }

    public function getModel()
    {
        return $this->model;
    }

    /**
     * 新增
     *
     * @param array $data
     *
     * @return Company|bool
     */
    public function create($data)
    {
        $model = $this->model;
        $model->forceFill(Arr::only($data, [
            'name',
            'stock_symbol',
            'industry',
            'introduction',
            'stock_exchanges',
            'stock_price',
            'nav',
        ]));

        $response = ($model->save()) ? $model : false;

        return $response;
    }

    /**
     * 更新
     *
     * @param Company|int $model
     * @param array             $data
     *
     * @return Company|bool
     */
    public function update($model, array $data)
    {
        if (!$model instanceof Company) {
            /** @var Company $model */
            $model = $this->model->where('id', $model)
                                 ->first();
        }

        // 刪除所有公司財報資訊
        // $model->furtherCompanys()->delete();
        // $this->createFurtherCompanys($model, $data);

        $model->forceFill(Arr::only($data, [
            'name',
            'stock_symbol',
            'industry',
            'introduction',
            'stock_exchanges',
            'stock_price',
            'nav',
        ]));

        return ($model->save()) ? $model : false;
    }

    /**
     * 透過搜尋條件取得資料
     *
     * @param string|array $columns
     * @param array        $condition
     * @param array        $order
     * @param int          $perPage
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getByCondition($columns = '*', $condition = [], $order = [], $perPage = 15)
    {
        $queryName = function ($query) use ($condition) {
            if (isset($condition['name']) && (trim($condition['name']) != '')) {
                $query->where('name', 'LIKE', "%{$condition['name']}%");
            }
            if (isset($condition['industry']) && (trim($condition['industry']) != '')) {
                $query->where('industry', 'LIKE', "%{$condition['industry']}%");
            }
            if (isset($condition['stock_exchanges']) && (trim($condition['stock_exchanges']) != '')) {
                $query->where('stock_exchanges', 'LIKE', "%{$condition['stock_exchanges']}%");
            }
        };

        return $this->model->select($columns)
                           ->where($queryName)
                           ->basicWhere(['id', 'stock_symbol', 'stock_exchanges'], $condition)
                           ->basicOrder($order)
                           ->basicPaginate($perPage);
    }

    public function getById($id)
    {
        return Company::where('id', $id)
            ->first();
    }
}
