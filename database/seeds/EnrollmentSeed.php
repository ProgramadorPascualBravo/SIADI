<?php

use Illuminate\Database\Seeder;

class EnrollmentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       factory(\App\Enrollment::class, 40)->create();
    }
}
