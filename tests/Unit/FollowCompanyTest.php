<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use App\Company;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FollowCompanyTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testFollowCompany()
    {
        $user = factory(User::class)->create();
        $company = factory(Company::class)->create();
        

        $user->followCompany($company->id);
        $this->assertTrue($user->followedCompanies()->get()->count() > 0);

        $user->unFollowCompany($company->id);
        $this->assertTrue($user->followedCompanies()->get()->count() < 1);
    }
}
