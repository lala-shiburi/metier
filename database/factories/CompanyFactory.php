<?php

use Faker\Generator as Faker;

$factory->define(\App\Company::class, function (Faker $faker) {
    $province = \DB::table('provinces')->inRandomOrder()->first();
    return [
        "name"=>$faker->company(),
        "address"=>$faker->streetAddress(),
        "email"=>$faker->unique()->safeEmail,
        "website_url"=>$faker->company().".com",
        "province"=>$province->name,
    ];
});
