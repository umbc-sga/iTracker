<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfileData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('api_id')->unsigned()->unique();
            $table->integer('user_id')->unsigned();
            $table->text('biography')->nullable();
            $table->string('major', 100)->nullable();
            $table->enum('classStanding', [
                'freshman',
                'sophomore',
                'junior',
                'senior',
                'graduate',
                'staff'
            ])->nullable();
            $table->string('hometown', 150)->nullable();
            $table->string('fact', 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
