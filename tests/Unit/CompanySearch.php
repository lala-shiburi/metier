<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Company;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanySearch extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSearchCompany()
    {
        $company = factory(Company::class)->create();

        $search = Company::searchKeyword($company->name);
        $this->assertEquals($company->name, $search->first());
    }
}
