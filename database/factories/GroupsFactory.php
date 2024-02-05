<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Group::class, function (Faker $faker) {
    return [
       "code" => $faker->countryCode,
       "name" => $faker->company,
       "state" => $faker->numberBetween(0, 1),
       "course_id" => \App\Program::find($faker->numberBetween(1, 5))->id
    ];
});
