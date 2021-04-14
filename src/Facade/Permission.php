<?php


namespace Iwindy\LaravelPermission\Facade;


use Illuminate\Support\Facades\Facade;

/**
 * Class Permission
 * @mixin \Iwindy\LaravelPermission\Permission
 * @method static getAuthNodesTree()
 * @method static generateFullNodes()
 * @method \Illuminate\Support\Collection getNodes() static
 *
 * @see \Iwindy\LaravelPermission\Permission
 */
class Permission extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Iwindy\LaravelPermission\Permission::class;
    }
}
