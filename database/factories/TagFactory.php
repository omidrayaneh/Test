<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'title'=>$faker->title,
        'slug'=>$faker->slug,
        'description'=>$faker->text(20),
        'status'=>$faker->boolean
    ];
});
