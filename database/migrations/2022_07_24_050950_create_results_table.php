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
        Schema::create('results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('result_user_id');
            $table->unsignedBigInteger('result_form_id');
            $table->unsignedBigInteger('result_response_id');
            $table->timestamps();

            $table->foreign('result_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('result_form_id')->references('id')->on('forms')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('result_response_id')->references('id')->on('responses')->onDelete('cascade')->onUpdate('cascade');
          });
        DB::unprepared('ALTER TABLE `results` DROP PRIMARY KEY, ADD PRIMARY KEY (  `id` ,  `result_user_id`, `result_form_id`,`result_response_id` )');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
};
