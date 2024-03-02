<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ts_report_id')->nullable();
            $table->foreign('ts_report_id')->references('id')->on('tabu_search_reports')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('class_name');
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
        Schema::dropIfExists('class_reports');
    }
}
