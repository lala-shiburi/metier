<?php

namespace Tests\Unit;
include_once 'App\Http\helper.php';

use Tests\TestCase;
use Carbon\Carbon;
use Faker\Factory as Faker;
use \App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddFunctions(){

        $faker = Faker::create('en_US');

        print('Testing Add functions... || ');
        //factory random user Basic Info
        $user = factory(User::class)->create();
        print('Basic Info success || ');

        // add functions
        $user->addUpdateAddress([
            'address_text'=>$faker->address,
            'province'=>'cebu',
        ]);
        print('address success || ');

        $user->addUpdateContactNumber([
            'number'=>$faker->phoneNumber
        ]);
        print('contact number success || ');

        $user->addUpdateProgrammingLanguage([
            'id'=>\App\ProgrammingLanguage::inRandomOrder()->first()->id,
            'expertise_level'=>1,
        ]);
        print('programming language success || ');

        $user->addUpdateTechnology([
            'id'=>\App\Technology::inRandomOrder()->first()->id,
            'expertise_level'=>1,
        ]);
        print('technology success || ');

        $user->addUpdateWorkExperience([
            'company_name'=>$faker->name,
            'position'=>"Software Developer",
            'from'=>"2016-06-04",
            'to'=>"2018-06-04",
        ]);
        print('work experience success || ');

        $user->addUpdateEducationalBackground([
            'school_name'=>"School Name Placeholder".time(),
            'school_address'=>$faker->address,
            'school_email'=>$faker->unique()->safeEmail,
            'school_number'=>$faker->phoneNumber,
            'course'=>"BSIT",
            'from'=>"2016-06-04",
            'to'=>"2018-06-04",
        ]);
        print('educational background success || ');

        // image tests
        $base64 = generateImageBase64('images/member-placeholder.png');
        $user->saveProfilePhoto($base64);
        print('profile photo success || ');
        $base64 = generateImageBase64('images/default-opening.png');
        $user->saveCoverPhoto($base64);
        print('profile photo success || ');

        $file = new \Symfony\Component\HttpFoundation\File\UploadedFile(public_path('/doc/sample-resume.pdf'),'sample-resume.pdf', null, null, null, true);
        copy(public_path('/doc/sample-resume.pdf'),public_path('/doc/sample-resume-copy.pdf'));
        $user->saveResumeFile($file);
        rename(public_path('/doc/sample-resume-copy.pdf'), public_path('/doc/sample-resume.pdf'));
        print('resume upload success');

        $this->assertTrue(true);

        print("Testing update functions... || ");

        $user->updateFields([
            "first_name"=>$faker->firstName,
            "middle_name"=>$faker->lastName,
            "last_name"=>$faker->lastName,
            "birth_date"=>$faker->dateTimeThisCentury->format('Y-m-d'),
            "citizenship"=>"Filipino",
            "password"=>'$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
        ]);
        print("Basic info success || ");
        
        $language_id = $user->programmingLanguages()->first()->pivot->language_id;
        $user->addUpdateProgrammingLanguage([
            "expertise_level"=>2
        ],$language_id);
        print("User programming language success || ");
        $this->assertEquals($user->programmingLanguages()->first()->pivot->expertise_level,2);
        
        $technology_id = $user->userTechnologies()->first()->pivot->technology_id;
        $user->addUpdateTechnology([
            "expertise_level"=>2
        ],$technology_id);
        print("User technology success || ".$technology_id."|||");
        $this->assertEquals($user->userTechnologies()->first()->pivot->expertise_level,2);

        $user->addUpdateWorkExperience([
            'company_name'=>$faker->name,
            'position'=>"Software Developer",
            'from'=>"2016-06-04",
            'to'=>"2018-06-04",
        ], $user->workExperiences()->first()->id);
        print('work experience success || ');

        $user->addUpdateEducationalBackground([
            'school_name'=>"School Name Placeholder".time(),
            'school_address'=>$faker->address,
            'school_email'=>$faker->unique()->safeEmail,
            'school_number'=>$faker->phoneNumber,
            'course'=>"BSIT",
            'from'=>"2016-06-04",
            'to'=>"2018-06-04",
        ], $user->educationalBackgrounds()->first()->id);
        print('educational background success || ');

        $this->assertTrue(true);

    }

    public function testDeleteFunctions(){
        print('Deleting User Model Instance || ');
        $user = factory(User::class)->create();
        $user->delete();
        print("success user delete || ");

        $this->assertTrue(true);
    }
}
