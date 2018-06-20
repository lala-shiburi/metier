<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\TrainingResultNote;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrainingResultNoteTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $training_note = factory(TrainingResultNote::class)->create();
        $this->assertTrue(true);
    }

    public function testDelete(){
        $training_note = factory(TrainingResultNote::class)->create();
        $training_note->delete();
        $this->assertTrue(True);
    }
}
