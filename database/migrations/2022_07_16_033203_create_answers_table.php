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
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('answer_user_id');
            $table->unsignedBigInteger('answer_response_id');
            $table->unsignedBigInteger('answer_question_id');
            $table->unsignedBigInteger('answer_choice_id')->nullable();
            $table->string('answer');
            $table->timestamps();

            $table->foreign('answer_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('answer_response_id')->references('id')->on('responses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('answer_question_id')->references('id')->on('questions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('answer_choice_id')->references('id')->on('choices')->onDelete('cascade')->onUpdate('cascade');
        });
        DB::unprepared('ALTER TABLE `answers` DROP PRIMARY KEY, ADD PRIMARY KEY (  `id` ,  `answer_user_id`, `answer_response_id`, `answer_question_id`)');
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answers');
    }
};
