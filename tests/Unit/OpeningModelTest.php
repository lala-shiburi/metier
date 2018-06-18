<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use \App\Opening;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OpeningModelTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAdd()
    {
        $opening = factory(Opening::class)->create();
        print(" Opening Instance created || ");

        $opening->addUpdateProgrammingLanguage([
            "id"=>\App\ProgrammingLanguage::inRandomOrder()->first()->id,
            "expertise_level"=>1
        ]);
        print(" Opening programming language successfully added || ");

        $opening->addUpdateTechnology([
            "id"=>\App\Technology::inRandomOrder()->first()->id,
            "expertise_level"=>1
        ]);
        print(" Opening technology successfully added || ");

        $this->assertTrue(true);
    }

    public function testDelete(){
        $opening = Opening::latest()->first();

        $opening->delete();

        print(" Opening model Instance delete successful || ");

        return $this->assertTrue(true);
    }
}
