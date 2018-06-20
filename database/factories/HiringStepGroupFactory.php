<?php

use Faker\Generator as Faker;

$factory->define(App\HiringStepGroup::class, function (Faker $faker) {
    $company = factory(App\Company::class)->create();
    return [
        "company_id"=>$company->id,
        "name"=>"Test Name",
        "description"=>$faker->text
    ];
});
