<?php

use Faker\Generator as Faker;

$factory->define(App\Opening::class, function (Faker $faker) {
    $company = factory(App\Company::class)->create();
    return [
        "company_id"=>$company->id,
        "title"=>"Opening Title",
        "hiring_step_group_id"=>1,
        "details"=>$faker->text,
    ];
});
