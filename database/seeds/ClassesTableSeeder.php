<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = array(
            ['id' => 1,'name' => 'X MIPA 1','class_major' =>'IPA', 'total_student' => '36'],
            ['id' => 2,'name' => 'X MIPA 2','class_major' =>'IPA', 'total_student' => '36'],
            ['id' => 3,'name' => 'X MIPA 3','class_major' =>'IPA', 'total_student' => '38'],
            ['id' => 4,'name' => 'X MIPA 4','class_major' =>'IPA', 'total_student' => '38'],
            ['id' => 5,'name' => 'X MIPA 5','class_major' =>'IPA', 'total_student' => '38'],
            ['id' => 6,'name' => 'X MIPA 6','class_major' =>'IPA', 'total_student' => '38'],
            ['id' => 7,'name' => 'X MIPA 7','class_major' =>'IPA', 'total_student' => '38']
        );

        foreach ($classes as $class) {
            if (DB::table('classrooms')->where('id', $class['id'])) {
                DB::table('classrooms')->updateOrInsert($class);
            }
        }
    }
}
