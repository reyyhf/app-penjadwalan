<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKolomToCurriculumLessons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('curriculum_lessons', function (Blueprint $table) {
            $table->integer('weight_x')->nullable()->change();
            $table->integer('weight_xi')->nullable()->change();
            $table->integer('weight_xii')->nullable()->change();
            $table->integer('weight_x_ips')->nullable()->after('weight_x');
            $table->integer('weight_xi_ips')->nullable()->after('weight_xi');
            $table->integer('weight_xii_ips')->nullable()->after('weight_xii');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('curriculum_lessons', function (Blueprint $table) {
        });
    }
}
