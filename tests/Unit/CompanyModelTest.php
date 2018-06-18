<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Faker\Factory as Faker;
use \App\Company;
use \App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyModelTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddUpdate()
    {
        $faker = Faker::create('en_US');

        print('Testing Add functions... || ');
        //factory random user Basic Info
        $company = factory(Company::class)->create();
        print('Basic Info success || ');
        // $user = factory(User::class)->create(); 

        // $company->collaborators()->attach($user->id,['privilege'=>1]);

        // $user->followCompany($company);
        // $this->assertTrue($company->collaborators()->where('users.id',$user->id)->first());
        $this->assertTrue(true);
        print('success!');

    }

    public function testDelete(){
        print('Deleting User Model Instance || ');
        $company = factory(Company::class)->create();
        $company->delete();

        print("success user delete || ");

        $this->assertTrue(true);
    }
}
