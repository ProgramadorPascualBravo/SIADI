<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Program::class, function (Faker $faker) {
    return [
       "name" => $faker->company,
       "faculty" => $faker->company,
       "code" => $faker->numerify('###'),
       "state" => $faker->numberBetween(0, 1),
       "department_id" => \App\Department::find($faker->numberBetween(1, 5))->id
    ];
});
