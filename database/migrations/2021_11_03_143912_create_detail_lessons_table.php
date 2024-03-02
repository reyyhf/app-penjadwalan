<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('lesson_hour_id');
            $table->unsignedInteger('curriculum_id');
            $table->string('day');
            $table->integer('hour');
            $table->integer('weight');
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
        Schema::dropIfExists('detail_lessons');
    }
}
