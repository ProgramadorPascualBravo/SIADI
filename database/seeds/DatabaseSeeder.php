<?php

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

        $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
        //$this->call(ProgramSeeder::class);
        //$this->call(CourseSeeder::class);
        //$this->call(GroupSeeder::class);
        //$this->call(StudentSeeder::class);
        //$this->call(EnrollmentSeed::class);
        $this->call(PermissionsSeeder::class);
    }
}
