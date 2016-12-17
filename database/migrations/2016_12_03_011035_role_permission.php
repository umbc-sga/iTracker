<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //@todo Normalize this DB
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_role_id')->unsigned();
            $table->string('permission',80);
            $table->timestamps();

            $table->unique(['organization_role_id', 'permission']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_permissions', function(Blueprint $table){
            $table->dropUnique('role_permissions_organization_role_id_permission_unique');
        });
        Schema::dropIfExists('role_permissions');
    }
}
