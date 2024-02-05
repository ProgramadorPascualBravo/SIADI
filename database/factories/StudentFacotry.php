<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Student::class, function (Faker $faker) {
    return [
       "name" => $faker->name,
       "last_name" => $faker->lastName,
       "email" => $faker->email,
       "password" => md5('1990duqe'),
       "document" => rand(10000000, 99999999),
       "country" => $faker->country,
       "department" => $faker->state,
       "city" => $faker->city,
       "address" => $faker->address,
       "telephone" => $faker->phoneNumber,
       "cellphone" => $faker->phoneNumber
    ];
});
