<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = array(
            ['id' => 1, 'name' =>'Senin'],
            ['id' => 2, 'name' =>'Selasa'],
            ['id' => 3, 'name' =>'Rabu'],
            ['id' => 4, 'name' =>'Kamis'],
            ['id' => 5, 'name' =>'Jumat'],
            ['id' => 6, 'name' =>'Sabtu']
        );

        foreach ($days as $day) {
            if (DB::table('days')->where('id', $day['id'])) {
                DB::table('days')->updateOrInsert($day);
            }
        }
    }
}
