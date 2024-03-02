<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryLessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            ['id' => 1,'name' => 'Mata Pelajaran Wajib A'],
            ['id' => 2,'name' => 'Mata Pelajaran Wajib B'],
            ['id' => 3,'name' => 'Muatan Lokal'],
            ['id' => 4,'name' => 'Mata Pelajaran Peminatan IPA'],
            ['id' => 5,'name' => 'Mata Pelajaran Peminatan IPS'],
            ['id' => 6,'name' => 'Mata Pelajaran Lintas Minat IPA'],
            ['id' => 7,'name' => 'Mata Pelajaran Lintas Minat IPS']
        );

        foreach ($categories as $category) {
            if (DB::table('category_lessons')->where('id', $category['id'])) {
                DB::table('category_lessons')->updateOrInsert($category);
            }
        }
    }
}
