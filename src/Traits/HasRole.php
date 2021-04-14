<?php


namespace Iwindy\LaravelPermission\Traits;


use Iwindy\LaravelPermission\Exceptions\PermissionDoesNotExist;
use Iwindy\LaravelPermission\Facade\Permission;

trait HasRole
{
    public function roleHasPermission()
    {
        return $this->hasMany(
            config('permission.models.role_has_permission'),
        );
    }

    /**
     * @param mixed ...$permissions
     * @return HasRole
     */
    public function savePermission(...$permissions){
        $all_permissions_nodes = Permission::getNodes();
        collect(...$permissions)->map(function ($permission) use ($all_permissions_nodes) {
            if (!$all_permissions_nodes->contains($permission)) {
                throw PermissionDoesNotExist::save($permission);
            }
        });

        $stored_permissions = $this->roleHasPermission()->pluck('permission');
        // add permissions
        collect(...$permissions)
            ->diff($stored_permissions)
            ->map(function ($permission) {
                return ['permission' => $permission];
            })->whenNotEmpty(function ($permissions) {
                $this->roleHasPermission()->createMany($permissions);
            });

        // remove permissions
        $stored_permissions
            ->diff(...$permissions)
            ->map(function ($permission) {
                $this->roleHasPermission()->where('permission', $permission)->delete();
            });

        return $this;
    }
}
