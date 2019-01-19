<?php

use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {

    return [
        'user_id' => $faker->uuid,
        'name' => $faker->name,
        'type' => $faker->randomElement(['image/jpg','image/png']),
        'path' => 'storage/'.$faker->name,
        'size' => $faker->phoneNumber,
        'created_at' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
        'updated_at' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
    ];
});
