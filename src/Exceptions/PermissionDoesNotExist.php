<?php

namespace Iwindy\LaravelPermission\Exceptions;

use InvalidArgumentException;

class PermissionDoesNotExist extends InvalidArgumentException
{
    public static function save(string $permissionName)
    {
        return new static("The `{$permissionName}` permission route  is not declared");
    }
}
