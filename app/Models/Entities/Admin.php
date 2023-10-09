<?php

namespace App\Models\Entities;

use App\Models\Presenters\AdminPresenter;
use App\Models\Presenters\PresentableTrait;
use Database\Factories\AdminFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements UserInterface
{
    use HasFactory;
    use Notifiable;
    use PresentableTrait;
    use BasicScopeTrait;

    public const STATUS_ENABLE = 1;
    public const STATUS_DISABLE = 0;
    public const PROTECTED_TRUE = 1;
    public const PROTECTED_FALSE = 0;

    protected $presenter = AdminPresenter::class;
    protected $hidden = ['password', 'oauth_token', 'remember_token',];

    protected static function newFactory()
    {
        return AdminFactory::new();
    }

    /**
     * 將權限轉換為字串形式
     *
     * @param array|string $value
     *
     * @return string
     */
    public function setRoleAttribute($value)
    {
        $value = (is_array($value)) ? $value : [$value];
        $this->attributes['role'] = implode(',', $value);
    }

    /**
     * 權限轉為array形式
     *
     * @param string $value
     *
     * @return array
     */
    public function getRoleAttribute($value)
    {
        return explode(',', $value);
    }

    /**
     * 檢查是否擁有權限
     *
     * @param array|string $roles
     *
     * @return bool
     */
    public function hasRole($roles)
    {
        $roles = (!is_array($roles)) ? [$roles] : $roles;
        // 最高權限
        if (in_array(Role::ADMIN, $this->role, true)) {
            return true;
        }

        return (count(array_diff($roles, $this->role)) < count($roles)) ? true : false;
    }
}
