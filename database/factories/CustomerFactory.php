<?php

use App\Entities\Customer;
use App\Infrastructure\Uuid;

$factory->define(Customer::class, function (Faker\Generator $faker) {
    return [
        'id' => new Uuid,
        'firstName' => $faker->firstName,
        'lastName' => $faker->lastName,
        'username' => $faker->userName,
        'email' => $faker->email,
        'password' => '5f4dcc3b5aa765d61d8327deb882cf99',
        'gender' => $faker->randomElement(['female', 'male']),
        'country' => $faker->country,
        'city' => $faker->city,
        'phone' => $faker->phoneNumber,
    ];
});