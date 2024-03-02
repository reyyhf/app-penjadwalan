<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('class_report_id')->nullable();
            $table->foreign('class_report_id')->references('id')->on('class_reports')->onUpdate('cascade')->onDelete('cascade');
            $table->string('day');
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
        Schema::dropIfExists('schedule_reports');
    }
}
