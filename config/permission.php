<?php

return [
    'models' => [
        'role'             => Iwindy\LaravelPermission\Models\Role::class,
        'role_has_permission'  => Iwindy\LaravelPermission\Models\RoleHasPermission::class,
        'model_permission' => Iwindy\LaravelPermission\Models\ModelPermission::class,
        'model_role'       => Iwindy\LaravelPermission\Models\ModelRole::class,
    ],

    'table_names' => [
        // 角色表
        'role'             => 'role',
        // 角色权限表
        'role_has_permission'  => 'role_has_permission',
        // 管理员角色表
        'model_role'       => 'model_role',
        // 管理员权限表
        'model_permission' => 'model_permission',
    ],
];
