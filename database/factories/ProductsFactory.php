<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name,
        'photo' => 'http://lorempixel.com/640/480/',
        'price' => $faker->numberBetween(10,1000),
    ];
});
