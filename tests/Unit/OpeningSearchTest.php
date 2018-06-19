<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Opening;
use App\Company;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OpeningSearchTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testOpeningSearchTest()
    {
        $opening = factory(Opening::class)->create([
            "professional_years"=>3,
            "salary_range"=>"10,000 ~ 15,000"
        ]);
        $company = $opening->company;

        $language_id = \App\ProgrammingLanguage::inRandomOrder()->first()->id;
        $opening->addUpdateProgrammingLanguage([
            "id"=>$language_id,
            "expertise_level"=>1
        ]);
        
        $technology_id = \App\Technology::inRandomOrder()->first()->id;
        $opening->addUpdateTechnology([
            "id"=>$technology_id,
            "expertise_level"=>1
        ]);

        $this->assertTrue(Opening::searchJobTitle($opening->title)->where("openings.id",$opening->id)->count() > 0);
        $this->assertTrue(Opening::searchCompanyName($company->name)->where("openings.id",$opening->id)->count() > 0);
        $this->assertTrue(Opening::searchProfYears(3)->where("openings.id",$opening->id)->count() > 0);
        $this->assertTrue(Opening::searchTechnology([$technology_id])->where("openings.id",$opening->id)->count() > 0);
        $this->assertTrue(Opening::searchProgrammingLanguages([$language_id])->where("openings.id",$opening->id)->count() > 0);
        $this->assertTrue(Opening::searchProvince([$company->province])->where("openings.id",$opening->id)->count() > 0);
        $this->assertTrue(Opening::searchSalaryRange($opening->salary_range)->where("openings.id",$opening->id)->count() > 0);
    }
}
