<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('permission.table_names.model_role'), function (Blueprint $table) {
            $table->primary(['role_id', 'model_id']);
            $table->unsignedInteger('role_id');
            $table->unsignedInteger('model_id');
            $table->string('model_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('permission.table_names.model_role'));
    }
}
