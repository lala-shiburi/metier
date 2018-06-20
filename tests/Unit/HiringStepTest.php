<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HiringStepTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $hiring_step = factory(\App\HiringStep::class)->create();
        $this->assertTrue(true);
    }

    public function testDelete(){
        $hiring_step = factory(\App\HiringStep::class)->create();
        $hiring_step->delete();
        $this->assertTrue(true);
    }
}
