<?php

use Faker\Generator as Faker;

$factory->define(App\HiringStep::class, function (Faker $faker) {
    $hiring_step_group = factory(App\HiringStepGroup::class)->create();
    return [
        "hiring_step_group_id"=>$hiring_step_group->id,
        "name"=>"Test Hiring Step Name",
        "description"=>$faker->text,
        "level"=>1
    ];
});
