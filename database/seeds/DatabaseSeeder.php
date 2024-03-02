<?php

use App\CurriculumLesson;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PositionsTableSeeder::class);
        // $this->call(CategoryLessonsTableSeeder::class);
        $this->call(ClassesTableSeeder::class);
        // $this->call(CurriculumLessonsTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TeacherLessonsTableSeeder::class);
        $this->call(DaysTableSeeder::class);
    }
}
