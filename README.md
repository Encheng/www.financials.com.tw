# Read Me

## environment

| 名稱     | 版本    | 備註               |
| -------- | ------- | ------------------ |
| Laravel  | ^9.0    | PHP最低版本須為8.0 |
| Composer | 2.1.14  |                    |
| Node.js  | 12.18.3 |                    |
| Vue      | 2.6.14  |                    |

- [Laravel Release Notes](https://laravel.com/docs/9.x/releases)
- [Upgrade guides for Composer 1.x to 2.0](https://getcomposer.org/upgrade/UPGRADE-2.0.md)

- [Node.js Releases](https://nodejs.org/en/about/releases/)

**Local環境切換node.js版本**

```bash
nvm install 12.18.3
nvm use 12.18.3
node -v
```

## Package

| 名稱      | 版本   | 備註                            |
| --------- | ------ | ------------------------------- |
| AdminLTE  | ^2.4   |                                 |
| Bootstrap | v4.3.1 | Bootstrap 4 Dropping Glyphicons |

## Route Naming Rule

ref. [resource-controllers](https://laravel.com/docs/5.7/controllers#resource-controllers)

| Verb      | URI                    | Action  | Route Name     |
| --------- | ---------------------- | ------- | -------------- |
| GET       | `/photos`              | index   | photos.index   |
| GET       | `/photos/create`       | create  | photos.create  |
| POST      | `/photos`              | store   | photos.store   |
| GET       | `/photos/{photo}`      | show    | photos.show    |
| GET       | `/photos/{photo}/edit` | edit    | photos.edit    |
| PUT/PATCH | `/photos/{photo}`      | update  | photos.update  |
| DELETE    | `/photos/{photo}`      | destroy | photos.destroy |

## Redis Cache Naming Rule

使用`:`區分資源階層

```bash
SET admin:{id}:roles 'somestring'
```

刪除所有用戶roles快取

```bash
DEL admin:*:role
```

## Seeder

```bash
# cms seeder
php artisan migrate:refresh
php artisan db:seed --class="Database\\Seeders\\Admin\\DatabaseSeeder"
```

## 後台權限設置

權限群組`\App\Models\Entities\Role::class`，欲新增群組請於`class`中以`constan`宣告群組名稱，並同時於`list`中加入新增的群組。

```php
const ADMIN = 'admin';
const MANAGER = 'manager';

public static function list()
{
    return [self::ADMIN => '總管理', self::MANAGER => '管理員'];
}
```

`model`修改完成後，配置`config/permission.php`中宣告該群組可存取的`controller`。

> `Role::ADMIN`為最高權限，因此預設為可存取全部的controller; 其餘群組至少需配置`IndexController`

```php
return [
    \App\Models\Entities\Role::ADMIN => [],
    \App\Models\Entities\Role::MANAGER => [
        \App\Http\Controllers\Admin\IndexController::class,
    ],
];
```

## NavItems配置

`nav_items`中若無`route_name`者(資料夾節點)需配置`role`。依照`role`判斷其是否顯示(包含子選單項目)。

| id   | parent_id | active_nav_item_id | name     | route_name | role  | icon         | display | created_at            | updated_at            |
| ---- | --------- | ------------------ | -------- | ---------- | ----- | ------------ | ------- | --------------------- | --------------------- |
| 2    | 1         |                    | 帳號管理 |            | admin | fa fa-folder | 1       | 2019-12-01 01:26:06.0 | 2019-12-01 01:26:06.0 |

若有`route_name`則不須配置`role`，透過`config/permission.php`判斷是否顯示與存取`controller`。

| id   | parent_id | active_nav_item_id | name     | route_name           | role | icon       | display | created_at            | updated_at            |
| ---- | --------- | ------------------ | -------- | -------------------- | ---- | ---------- | ------- | --------------------- | --------------------- |
| 3    | 2         |                    | 帳號列表 | admin.accounts.index |      | fa fa-list | 1       | 2019-12-01 01:26:06.0 | 2019-12-01 01:26:06.0 |

進入route後展開上層folder。

| id   | parent_id | active_nav_item_id | name     | route_name          | role | icon | display | created_at            | updated_at            |
| ---- | --------- | ------------------ | -------- | ------------------- | ---- | ---- | ------- | --------------------- | --------------------- |
| 5    | 2         | 2                  | 帳號編輯 | admin.accounts.edit |      |      | 0       | 2019-12-01 01:26:06.0 | 2019-12-01 01:26:06.0 |

> 由於route權限判斷抽離，nav_items僅需紀錄上述三種類型
> 實作方式請參考`\Database\Seeders\Admin\AdminNavItemSeeder::class`

### 清除快取

```bash
php artisan nav_items:cache_clear
```

## 專案使用方法

- 新增公司
- 批次匯入公司財報資料
- 使用command計算該公司的ROE/IRR/RIR等數據
- 從公司列表查看該公司的分析結果