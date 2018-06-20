<?php

use Faker\Generator as Faker;

$factory->define(App\HiringStepResult::class, function (Faker $faker) {
    $hiring_step = factory(App\HiringStep::class)->create();
    $hiring_application = factory(App\HiringApplication::class)->create();
    return [
        "hiring_application_id"=>$hiring_application->id,
        "hiring_step_id"=>$hiring_step->id,
        "result"=>"failed",
    ];
});
