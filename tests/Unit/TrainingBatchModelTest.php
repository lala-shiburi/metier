<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\TrainingBatch;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TrainingBatchModelTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $trainingBatch = factory(TrainingBatch::class)->create();

        $this->assertTrue(true);
    }

    public function testDelete()
    {
        $trainingBatch = factory(TrainingBatch::class)->create();

        $this->assertTrue(true);
    }
}
