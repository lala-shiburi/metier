<?php

use Faker\Generator as Faker;

$factory->define(App\TrainingResultNote::class, function (Faker $faker) {
    $training_result = factory(\App\TrainingResult::class)->create();
    return [
        "training_result_id"=>$training_result->id,
        "title"=>"Note Title",
        "note"=>$faker->text
    ];
});
