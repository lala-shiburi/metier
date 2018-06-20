<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\HiringStepResultNote;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HiringStepResultNoteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $hiring_step_result_note = factory(HiringStepResultNote::class)->create();
        $this->assertTrue(true);
    }

    public function testDelete(){
        $hiring_step_result_note = factory(HiringStepResultNote::class)->create();
        $hiring_step_result_note->delete();
        $this->assertTrue(true);
    }
}
