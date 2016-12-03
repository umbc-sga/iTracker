<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_users', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('organization_id')->references('id')->on('organizations');
            $table->foreign('organization_role')->references('id')->on('organization_roles');
        });

        Schema::table('role_permission', function(Blueprint $table){
            $table->foreign('organization_role_id')->references('id')->on('organization_roles');
        });

        Schema::table('profiles', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_users', function(Blueprint $table){
            $table->dropForeign('organization_users_user_id_foreign');
            $table->dropForeign('organization_users_organization_id_foreign');
            $table->dropForeign('organization_users_organization_role_foreign');
        });

        Schema::table('role_permission', function(Blueprint $table){
            $table->dropForeign('role_permission_organization_role_id_foreign');
        });

        Schema::table('profiles', function(Blueprint $table){
            $table->dropForeign('profiles_user_id_foreign');
        });
    }
}
