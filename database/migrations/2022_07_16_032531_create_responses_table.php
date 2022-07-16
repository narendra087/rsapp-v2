<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('response_user_id');
            $table->unsignedBigInteger('response_form_id');
            $table->timestamps();

            $table->foreign('response_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('response_form_id')->references('id')->on('forms')->onDelete('cascade')->onUpdate('cascade');
          });
        DB::unprepared('ALTER TABLE `responses` DROP PRIMARY KEY, ADD PRIMARY KEY (  `id` ,  `response_user_id`, `response_form_id` )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responses');
    }
};
