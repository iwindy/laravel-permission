<?php


namespace Iwindy\LaravelPermission\Models;

use Illuminate\Database\Eloquent\Model;


class ModelPermission extends Model
{
    const CREATED_AT = null;

    const UPDATED_AT = null;

    protected $fillable =[
        'permission'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('permission.table_names.model_permission'));
    }
}
