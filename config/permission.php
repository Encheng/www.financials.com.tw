<?php

return [
    \App\Models\Entities\Role::ADMIN => [],
    \App\Models\Entities\Role::MANAGER => [
        \App\Http\Controllers\Admin\IndexController::class,
    ],
];
