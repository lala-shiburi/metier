<?php

use Faker\Generator as Faker;

$factory->define(App\HiringApplication::class, function (Faker $faker) {
    $user = factory(App\User::class)->create();
    $opening = factory(App\Opening::class)->create();
    return [
        "user_id"=>$user->id,
        "opening_id"=>$opening->id,
        "application_letter"=>$faker->text,
        "expected_salary"=>"10,000 ~ 15,000",
    ];
});
