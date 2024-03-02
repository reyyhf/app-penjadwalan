<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            ['id' => 1, 'employee_id' => 1, 'position_id' => 1, 'username' => '1234567', 'password' => '21232f297a57a5a743894a0e4a801fc3', 'password_description' => 'admin'],
            ['id' => 2, 'employee_id' => 2, 'position_id' => 2, 'username' => '2222222', 'password' => '21232f297a57a5a743894a0e4a801fc3', 'password_description' => 'admin']
        );

        foreach ($users as $user) {
            if (DB::table('users')->where('id', $user['id'])) {
                DB::table('users')->updateOrInsert($user);
            }
        }
    }
}
