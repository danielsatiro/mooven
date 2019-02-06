<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'login' => $faker->unique()->userName,
        'name' => $faker->name,
        'avatar_url' => $faker->unique()->imageUrl(640, 480, 'people', true, 'avatar'),
        'html_url' => $faker->unique()->url
    ];
});
