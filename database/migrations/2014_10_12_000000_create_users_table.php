<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_name');
            $table->string('user_username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('user_role_id');
            $table->date('user_birthday')->nullable();
            $table->string('user_address')->nullable();
            $table->bigInteger('user_phone')->nullable();
            $table->string('about_me')->nullable();
            $table->string('user_status')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
