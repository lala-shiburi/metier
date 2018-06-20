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
        $this->assertTrue(true);
        print('success!');

    }

    public function testCollaboratorEditFunction(){
        $company = factory(Company::class)->create();
        $user = factory(User::class)->create();

        $company->addCollaborator($user->id,1);

        $this->assertEquals($company->collaborators()->where("company_users.user_id",$user->id)->count(), 1);
        $company->removeCollaborator($user->id);
        $this->assertEquals($company->collaborators()->where("company_users.user_id",$user->id)->count(), 0);
    }

    public function testDelete(){
        print('Deleting User Model Instance || ');
        $company = factory(Company::class)->create();
        $company->delete();

        print("success user delete || ");

        $this->assertTrue(true);
    }
}
