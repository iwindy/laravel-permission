<?php


namespace Iwindy\LaravelPermission\Models;


use Illuminate\Database\Eloquent\Model;

class ModelRole extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('permission.table_names.model_role'));
    }
}
