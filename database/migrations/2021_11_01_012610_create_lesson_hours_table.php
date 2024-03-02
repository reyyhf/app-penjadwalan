<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lesson_hours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('class_id');
            $table->string('type_curriculum');
            $table->tinyInteger('status')->default(0)->comment('0-incomplete,1-complete');
            $table->year('start_period');
            $table->year('last_period');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lesson_hours');
    }
}
