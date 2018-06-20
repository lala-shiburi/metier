<?php

use Faker\Generator as Faker;

$factory->define(App\HiringStepResultNote::class, function (Faker $faker) {
    $hiring_step_result = factory(App\HiringStepResult::class)->create();
    return [
        "hiring_step_result_id"=>$hiring_step_result->id,
        "title"=>"Hiring Step Result Note title",
        "note"=>$faker->text,
    ];
});
