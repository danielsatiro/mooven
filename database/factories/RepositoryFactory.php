<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Repository::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->name,
        'description' => $faker->text
    ];
});
