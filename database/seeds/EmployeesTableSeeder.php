<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = array(
            ['id' => 1,'position_id' => 1,'nik' =>'1234567', 'name' => 'Agus', 'load_teacher' => '0'],
            ['id' => 2,'position_id' => 2,'nik' =>'2222222', 'name' => 'Priyadi', 'load_teacher' => '0'],
            ['id' => 3,'position_id' => 3,'nik' =>'3333333', 'name' => 'Tukiyem', 'load_teacher' => '3']
        );

        foreach ($employees as $employee) {
            if (DB::table('employees')->where('id', $employee['id'])) {
                DB::table('employees')->updateOrInsert($employee);
            }
        }
    }
}
