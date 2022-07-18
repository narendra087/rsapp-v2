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
        Schema::create('forms', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('form_name');
          $table->timestamps();
        });
        Schema::create('question_segments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('form_id');
            $table->string('question_segment');
            $table->string('question_segment_desc')->nullable();
            $table->string('question_segment_status')->nullable();
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade')->onUpdate('cascade');
        });
        DB::unprepared('ALTER TABLE `question_segments` DROP PRIMARY KEY, ADD PRIMARY KEY (  `id` ,  `form_id` )');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_segments');
        Schema::dropIfExists('forms');
    }
};
