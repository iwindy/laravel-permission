<?php

namespace Iwindy\LaravelPermission\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Iwindy\LaravelPermission\Traits\HasRole;

/**
 * Class Role
 * @mixin Builder
 */
class Role extends Model
{
    use HasRole;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('permission.table_names.role'));
    }
}
