<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\User::class, function (Faker $faker) {
    return [
       "name" => 'Admin',
       "last_name" => 'SIADI',
       "username" => 'admin@pascualbravo.edu.co',
       "password" => \Illuminate\Support\Facades\Hash::make("siadi_123456789"),
       "document" => "123456789",
       "state" => 1,
       "verified" => 1,
       "department_id" => \App\Department::latest('id')->first()
    ];
});
