<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnEmployeeIdToTableDetailLessons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_lessons', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->after('lesson_hour_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_lessons', function (Blueprint $table) {
            $table->dropColumn('employee_id');
        });
    }
}
