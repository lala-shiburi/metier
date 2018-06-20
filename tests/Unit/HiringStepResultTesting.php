<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\HiringApplicationResult;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HiringStepResultTesting extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $hiring_step_result = factory(HiringApplicationResult::class)->create();
        $this->assertTrue(true);
    }

    public function testDelete(){
        $hiring_step_result = factory(HiringApplicationResult::class)->create();
        $hiring_step_result->delete();
        $this->assertTrue(true);
    }

}
