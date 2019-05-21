<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'product_id' => $faker->ean8,
        'description' => $faker->sentence(5),
        'category_id' => config('discounts.switchesCategoryId'),
        'price' => $faker->randomFloat(2, 10, 100),
    ];
});
