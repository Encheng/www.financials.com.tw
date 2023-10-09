<?php

namespace App\Models\Entities;

use Database\Factories\NavItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavItem extends Model
{
    use HasFactory;
    use BasicScopeTrait;

    public const DISPLAY_SHOW = 1;
    public const DISPLAY_HIDDEN = 0;

    protected $fillable = [
        'name',
        'parent_id',
        'route_name',
        'role',
        'active_nav_item_id',
        'icon',
        'display',
    ];

    protected static function newFactory()
    {
        return NavItemFactory::new();
    }

    public function parent()
    {
        return $this->belongsTo(NavItem::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(NavItem::class, 'parent_id');
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
        if ($value !== null) {
            $value = (is_array($value)) ? $value : [$value];
            $this->attributes['role'] = implode(',', $value);
        } else {
            $this->attributes['role'] = null;
        }
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
}
