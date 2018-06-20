<?php

use Faker\Generator as Faker;

$factory->define(\App\Company::class, function (Faker $faker) {
    $province = \DB::table('provinces')->inRandomOrder()->first();
    $user = factory(\App\User::class)->create();
    return [
        "name"=>$faker->company(),
        "owner_id"=>$user->id,
        "address"=>$faker->streetAddress(),
        "email"=>$faker->unique()->safeEmail,
        "website_url"=>$faker->company().".com",
        "province"=>$province->name,
    ];
});
