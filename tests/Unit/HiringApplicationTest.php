<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\HiringApplication;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HiringApplicationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $hiringApplication = factory(HiringApplication::class)->create();
        $this->assertTrue(true);
    }

    public function testDelete(){
        $hiringApplication = factory(HiringApplication::class)->create();

        $hiringApplication->delete();

        $this->assertTrue(true);
    }
}
