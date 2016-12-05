<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeUserOrgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->integer('organization_role')->unsigned()->nullable();
            $table->string('title', 200);
            $table->timestamps();

            $table->unique(['user_id', 'organization_id', 'organization_role'], 'unique_user_org_role');
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
            $table->dropUnique('unique_user_org_role');
        });

        Schema::dropIfExists('organization_users');
    }
}
