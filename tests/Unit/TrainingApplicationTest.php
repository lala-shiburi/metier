<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrainingApplicationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $trainingApplication = factory(\App\TrainingApplication::class)->create();
        $this->assertTrue(true);
    }

    public function testDelete(){
        $trainingApplication = factory(\App\TrainingApplication::class)->create();
        $trainingApplication->delete();
        $this->assertTrue(true);
    }
}
