<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use App\Company;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanySaveUser extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCompanySaveUser()
    {
        $user = factory(User::class)->create();
        $company = factory(Company::class)->create();

        $company->saveApplicant($user->id);
        $this->assertTrue($company->savedApplicants()->where("users.id",$user->id)->count() > 0);

        $company->unSaveApplicant($user->id);
        $this->assertTrue($company->savedApplicants()->where("users.id",$user->id)->count() < 1)
    }
}
