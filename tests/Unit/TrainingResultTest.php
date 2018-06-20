<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\TrainingResult;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrainingResultTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $training_result = factory(TrainingResult::class)->create();
        $this->assertTrue(true);
    }

    public function testDelete(){
        $training_result = factory(TrainingResult::class)->create();
        $training_result->delete();
        $this->assertTrue(true);
    }
}
