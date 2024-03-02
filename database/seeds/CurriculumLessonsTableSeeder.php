<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurriculumLessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $curriculums = array(
            ['id' => 1,'category_id' => 1,'name_lesson' =>'Matematika', 'weight_x' => '40', 'weight_xi' => '40', 'weight_xii' => '0'],
            ['id' => 2,'category_id' => 1,'name_lesson' =>'Matematika Wajib', 'weight_x' => '40', 'weight_xi' => '40', 'weight_xii' => '20']
        );

        foreach ($curriculums as $curriculum) {
            if (DB::table('curriculum_lessons')->where('id', $curriculum['id'])) {
                DB::table('curriculum_lessons')->updateOrInsert($curriculum);
            }
        }
    }
}
