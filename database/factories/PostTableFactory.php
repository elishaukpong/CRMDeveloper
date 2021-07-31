<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Post;
use App\User;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'content' => $faker->text(400),
        'views' => $faker->biasedNumberBetween(1,300),
        'user_id' => User::role('Writer')->get()->random()->first()->id
    ];
});
