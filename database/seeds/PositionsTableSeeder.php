<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = array(
            ['id' => 1,'name' => 'Kurikulum'],
            ['id' => 2,'name' => 'Tata Usaha'],
            ['id' => 3,'name' => 'Guru Tetap'],
            ['id' => 4,'name' => 'Guru Honorer']
        );

        foreach ($positions as $position) {
            if (DB::table('positions')->where('id', $position['id'])) {
                DB::table('positions')->updateOrInsert($position);
            }
        }
    }
}
