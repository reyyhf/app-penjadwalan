<?php

use Illuminate\Database\Seeder;

class TeacherLessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lessons = array(
            ['employee_id' => 3,'curriculum_id' => 1]
        );

        foreach ($lessons as $lesson) {
            if (DB::table('teacher_lessons')->where('employee_id', $lesson['employee_id'])->where('curriculum_id', $lesson['curriculum_id'])) {
                DB::table('teacher_lessons')->updateOrInsert($lesson);
            }
        }
    }
}
