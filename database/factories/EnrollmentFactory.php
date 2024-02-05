<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Enrollment::class, function (Faker $faker) {
   $roles = ['student', 'teacher', 'editingteacher'];
    return [
       'code' => \App\Group::find($faker->numberBetween(1, 10))->code,
       'email' => \App\Student::find($faker->numberBetween(1, 33))->email,
       'rol' => $roles[$faker->numberBetween(0, 2)],
       'state' => $faker->numberBetween(1,4)
    ];
});
