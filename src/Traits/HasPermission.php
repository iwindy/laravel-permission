<?php

namespace Iwindy\LaravelPermission\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Iwindy\LaravelPermission\Exceptions\PermissionDoesNotExist;
use Iwindy\LaravelPermission\Facade\Permission;
use Iwindy\LaravelPermission\Models\RoleHasPermission;


trait HasPermission
{
    /**
     * @return MorphMany
     */
    public function modelPermission()
    {
        return $this->morphMany(
            config('permission.models.model_permission'),
            'model'
        );
    }

    /**
     * @return RoleHasPermission|Builder
     */
    public function modelRole()
    {
        return $this->morphMany(
            config('permission.models.model_role'),
            'model'
        );
    }


    /**
     * @return RoleHasPermission|Builder
     */
    public function getRoleHasPermissionModelClass()
    {
        return app(config('permission.models.role_has_permission'));
    }


    /**
     * @param string $permission 权限标识
     * @return bool
     */
    public function checkPermission($permission)
    {
        if ($this->hasPermissionTo($permission)) {
            return true;
        }

        return $this->hasRolePermission();
    }

    /**
     * 判断管理员是否直接拥有权限
     * @param string $permission 权限标识
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        return $this->modelPermission()->where('permission', $permission)->exists();
    }

    /**
     * 判断管理员所属角色是否拥有权限
     * @return bool
     */
    public function hasRolePermission()
    {
        $model_role_ids = $this->modelRole()->pluck('role_id')->all();
        if (empty($model_role_ids)) {
            return false;
        }

        return $this->getRoleHasPermissionModelClass()->where('role_id', $model_role_ids)->exists();
    }

    /**
     * 直接给管理员设置权限
     * @param mixed ...$permissions
     * @return $this
     */
    public function savePermission(...$permissions)
    {
        $all_permissions_nodes = Permission::getNodes();
        collect(...$permissions)->map(function ($permission) use ($all_permissions_nodes) {
            if (!$all_permissions_nodes->contains($permission)) {
                throw PermissionDoesNotExist::save($permission);
            }
        });

        $stored_permissions = $this->modelPermission()->pluck('permission');
        // add permissions
        collect(...$permissions)
            ->diff($stored_permissions)
            ->map(function ($permission) {
                return ['permission' => $permission];
            })->whenNotEmpty(function ($permissions) {
                $this->modelPermission()->createMany($permissions);
            });

        // remove permissions
        $stored_permissions
            ->diff(...$permissions)
            ->map(function ($permission) {
                $this->modelPermission()->where('permission', $permission)->delete();
            });

        return $this;
    }

}
