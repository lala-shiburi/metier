<?php

use Faker\Generator as Faker;

$factory->define(App\TrainingBatch::class, function (Faker $faker) {
    $user = factory(App\User::class)->create([
        "role"=>2
    ]);
    return [
        "author_id"=>$user->id,
        "title"=>"Training Title",
        "description"=>$faker->text,
        "start_date"=>Carbon\Carbon::now()->addMonth(),
        "end_date"=>Carbon\Carbon::now()->addMonths(2),
        "registration_deadline"=>Carbon\Carbon::now()->addDays(28),
    ];
});
