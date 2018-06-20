<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\HiringStepGroup;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HiringStepGroupTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $hiring_step_group = factory(HiringStepGroup::class)->create();
        $hiring_step = factory(\App\HiringStep::class)->create([
            "hiring_step_group_id"=>$hiring_step_group->id
        ]);

        $this->assertEquals($hiring_step_group->hiring_steps()->count(),1);
    }

    public function testDelete(){
        $hiring_step_group = factory(HiringStepGroup::class)->create();
        $hiring_step_group_id = $hiring_step_group->id;
        $hiring_step = factory(\App\HiringStep::class)->create([
            "hiring_step_group_id"=>$hiring_step_group->id
        ]);
        $hiring_step_group->delete();
        $this->assertTrue(\App\HiringStep::where("hiring_step_group_id",$hiring_step_group_id)->count() < 1);
    }
}
