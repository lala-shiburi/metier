<?php

use Faker\Generator as Faker;

$factory->define(App\TrainingApplication::class, function (Faker $faker) {
    $training_batch = factory(App\TrainingBatch::class)->create();
    $applicant = factory(App\User::class)->create();
    return [
        "user_id"=>$applicant->id,
        "training_batch_id"=>$training_batch->id,
        "application_letter"=>$faker->text,
    ];
});
