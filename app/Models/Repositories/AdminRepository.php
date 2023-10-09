<?php

namespace App\Models\Repositories;

use App\Models\Entities\Admin;
use Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new Admin();
    }

    /**
     * 新增帳號
     *
     * @param array $data
     *
     * @return Admin|bool
     */
    public function create($data)
    {
        $model = new Admin();
        $model->name = $data['name'];
        $model->email = $data['email'];
        $model->password = Hash::make($data['password']);
        $model->status = $data['status'];
        $model->protected = $data['protected'];
        $model->role = $data['role'];
        $model->comment = filled($data['comment'] ?? null) ? $data['comment'] : null;

        return ($model->save()) ? $model : false;
    }

    /**
     * 透過搜尋條件取得資料
     *
     * @param string|array $columns
     * @param array        $condition
     * @param array        $order , ['id'=>'ASC']
     * @param int          $perPage
     *
     * @return LengthAwarePaginator|Collection
     */
    public function getByCondition($columns = '*', $condition = [], $order = [], $perPage = 15)
    {
        $whereInQuery = function ($query) use ($condition) {
            $columns = ['id', 'email'];
            foreach ($columns as $column) {
                /** @var Builder $query */
                if (isset($condition[$column])) {
                    if (is_array($condition[$column])) {
                        $query->whereIn($column, $condition[$column]);
                    } else {
                        $query->where($column, $condition[$column]);
                    }
                }
            }
        };

        $whereString = function ($query) use ($condition) {
            /** @var Builder $query */
            if (isset($condition['search']) && !empty($condition['search'])) {
                $condition['search'] = trim($condition['search']);
                $query->where('name', 'LIKE', "%{$condition['search']}%")
                      ->orWhere('comment', 'LIKE', "%{$condition['search']}%");
            }
        };

        $whereRole = function ($query) use ($condition) {
            /** @var Builder $query */
            if (isset($condition['role'])) {
                $query->where('role', 'LIKE', "%{$condition['role']}%");
            }
        };

        return $this->model->select($columns)
                           ->where($whereInQuery)
                           ->where($whereRole)
                           ->where($whereString)
                           ->basicWhere(['status', 'protected'], $condition)
                           ->basicOrder($order, 'admins')
                           ->basicPaginate($perPage);
    }

    /**
     * 透過email與其他條件查詢用戶
     *
     * @param string $email
     * @param array  $condition
     *
     * @return Admin|null
     */
    public function getUserByCondition($email, $condition = [])
    {
        return $this->model->where('email', $email)
                           ->basicWhere(['id', 'status', 'protected'], $condition)
                           ->first();
    }

    /**
     * 透過ID與其他條件查詢用戶
     *
     * @param int|string $id
     * @param array      $condition
     *
     * @return Admin|null
     */
    public function getUserById($id, $condition = [])
    {
        return $this->model->where('id', $id)
                           ->basicWhere(['status', 'protected'], $condition)
                           ->first();
    }

    /**
     * 更新帳號
     *
     * @param Admin|int $model
     * @param array     $data
     *
     * @return Admin|bool
     */
    public function update($model, $data)
    {
        $model = (!$model instanceof Admin) ? $this->model->onWriteConnection()
                                                          ->find($model) : $model;

        $columns = [
            'name',
            'password',
            'status',
            'protected',
            'role',
            'comment',
            'status',
            'display'
        ];
        foreach ($columns as $column) {
            if (array_key_exists($column, $data)) {
                $model->{$column} = $data[$column];
            }
        }

        return ($model->save()) ? $model : false;
    }
}
