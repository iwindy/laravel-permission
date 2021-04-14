<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('permission.table_names.model_permission'), function (Blueprint $table) {
            $table->unsignedInteger('model_id');
            $table->string('permission',191);
            $table->string('model_type');
            $table->primary(['model_id', 'permission']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('permission.table_names.model_permission'));
    }
}
