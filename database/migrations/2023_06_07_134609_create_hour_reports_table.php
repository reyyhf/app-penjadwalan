<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHourReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hour_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('schedule_report_id')->nullable();
            $table->foreign('schedule_report_id')->references('id')->on('schedule_reports')->onUpdate('cascade')->onDelete('cascade');
            $table->string('day_name');
            $table->integer('curriculum_lesson_id');
            $table->integer('id_guru');
            $table->string('acronym');
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
        Schema::dropIfExists('hour_reports');
    }
}
