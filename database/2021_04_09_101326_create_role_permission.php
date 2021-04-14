<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('permission.table_names.role_has_permission'), function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->string('permission',191);
            $table->primary(['role_id', 'permission']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('permission.table_names.role_has_permission'));
    }
}
