<?php

use Faker\Generator as Faker;

$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'image' => $faker->imageUrl(640, 480, 'cats'),
        'author' => $faker->firstNameMale . ' ' . $faker->lastName,
        'published_at' => $faker->date('d/m/Y', 'now'),
    ];
});
