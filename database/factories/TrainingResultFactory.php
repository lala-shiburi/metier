<?php

use Faker\Generator as Faker;

$factory->define(App\TrainingResult::class, function (Faker $faker) {
    $training_application = factory(App\TrainingApplication::class)->create();
    return [
        "training_application_id"=>$training_application->id,
        "result"=>"passed",
    ];
});
