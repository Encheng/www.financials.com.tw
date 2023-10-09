<?php

namespace App\Models\Entities;

class Role
{
    public const ADMIN = 'admin';
    public const MANAGER = 'manager';

    /**
     * @return array
     */
    public static function list()
    {
        return [
            self::ADMIN => '總管理',
            self::MANAGER => '管理員',
        ];
    }

    /**
     * 檢查權限是否存在
     *
     * @param array $roles
     *
     * @return bool
     */
    public static function exists(array $roles)
    {
        $keys = array_keys(self::list());

        return (count(array_diff($roles, $keys)) == 0) ? true : false;
    }
}
