<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    $title = $faker->sentence();
    return [
        'title' => $title,
        'slug' => str_slug($title),
        'body' => $faker->text(400)
    ];
});