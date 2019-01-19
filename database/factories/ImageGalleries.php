<?php

use Faker\Generator as Faker;

$factory->define(\App\Entities\ImageGalleries::class, function (Faker $faker) {

    return [
        'id'         => rand(1, 99),
        'name'       => $faker->name,
        'type'       => $faker->randomElement(['image/jpeg', 'image/png']),
        'path'       => 'storage/' . $faker->name,
        'size'       => rand(999,99999),
        'created_at' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
        'updated_at' => $faker->date($format = 'Y-m-d H:i:s', $max = 'now'),
    ];
});
