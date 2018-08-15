<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    // user routes
    Route::group(['prefix' => 'userInfo'], function(){
        // fetch'
        Route::group(['prefix' => 'fetch'], function(){
            Route::get('user', 'UserController@fetch_user');
            Route::get('programmingLanguages', 'UserController@fetch_programming_languages');
            Route::get('userTechnologies', 'UserController@fetch_technologies');
            Route::get('workExperiences', 'UserController@fetch_work_experience');
            Route::get('educationalBackgrounds', 'UserController@fetch_educational_background');
            Route::get('followedCompanies', 'UserController@fetch_followed_companies');
            Route::get('userAddresses', 'UserController@fetch_user_addresses');
            Route::get('userContactNumbers', 'UserController@fetch_user_contact_number');
            Route::get('companies', 'UserController@fetch_companies');
            Route::post('search', 'UserController@fetchSearch');
            Route::get('followed/companies', 'UserController@fetchFollowedCompanies');
        });
        // update
        Route::group(['prefix' => 'update'], function(){
            Route::post('skills', 'UserController@update_skills');
            Route::post('user_description', 'UserController@update_description');
            Route::post('basic_info', 'UserController@update_basic_info');
            Route::patch('photo', 'UserController@updatePhoto');
        });
        // add
        Route::group(['prefix' => 'add'], function(){
            Route::post('work_experience', 'UserController@add_work_experience');
            Route::post('education_background', 'UserController@add_education_background');
            Route::post('address', 'UserController@add_update_address');
            Route::post('contact_number', 'UserController@add_update_contact_number');
            Route::post('resume_file', 'UserController@uploadResumeFile');
            Route::post('follow/company', 'UserController@followCompany');
        });
        // delete
        Route::group(['prefix' => 'delete'],function(){
            Route::delete('work_experience', 'UserController@delete_work_experience');
            Route::delete('education_background', 'UserController@delete_education_background');
            Route::delete('address', 'UserController@delete_address');
            Route::delete('contact_number', 'UserController@delete_address');
        });
        
    });

    // company routes
    Route::group(['prefix' => "company"], function(){
        Route::post('create', 'CompanyController@create');
        Route::group(['prefix'=>'fetch'], function(){
            Route::get('/', 'CompanyController@fetch');
            Route::get('openings', 'CompanyController@fetch_openings');
            Route::get('hiring/applications', 'CompanyController@fetchHiringApplications');
            Route::get('hiring/applications2', 'CompanyController@fetchHiringApplications2');
            Route::get('collaborators', 'CompanyController@fetchCollaborators');
            Route::post('search', 'CompanyController@fetchCompanySearch');
            Route::get('isBookMarked', 'CompanyController@fetchIsBookMarked');
        });

        // add
        Route::group(['prefix'=>'add'], function(){
            Route::post('collaborator','CompanyController@addCollaborator');
        });

        // delete
        Route::group(['prefix'=>'delete'], function(){
            Route::delete('collaborator','CompanyController@removeCollaborator');
        });

        // update
        Route::group(['prefix' => 'update'], function(){
            Route::patch('basic/info', 'CompanyController@updateBasicInfo');
            Route::patch('website/info', 'CompanyController@updateWebsiteInfo');
        });
        
        Route::group(['prefix' => 'hiringprocess'], function(){
            // validate
            Route::group(['prefix' => 'validate'], function(){
                Route::post('process/step', 'HiringProcessController@validate_process_step');
                Route::post('hiring/step/result', 'HiringProcessController@validateHiringStepResult');
                Route::post('hiring/step/note', 'HiringProcessController@validateHiringStepResultNote');
            });
            // create
            Route::group(['prefix' => 'create'], function(){
                Route::post('process', 'HiringProcessController@createHiringProcess');
                Route::post('step/result', 'HiringProcessController@createStepResult');
            });
            // fetch
            Route::group(['prefix'=>'fetch'], function(){
                Route::get('processes', 'HiringProcessController@fetchProcesses');
                Route::get('one/process', 'HiringProcessController@fetchProcess');
            });
            // delete
            Route::group(['prefix' => 'delete'], function(){
                Route::delete('process', 'HiringProcessController@deleteProcess');
            });
        });
    });

    // opening routes
    Route::group([ "prefix" => "opening" ], function(){
        // fetch
        Route::group(['prefix'=>'fetch'], function(){
            Route::get('/', 'OpeningController@fetch');
            Route::post('search', 'OpeningController@search');
        });

        Route::group(["prefix" => "validate"],function(){
            Route::post('basicInfo', 'OpeningController@validateBasicInfo');
            Route::post('description', 'OpeningController@validateDescription');
        });
        
        Route::post('create', 'OpeningController@create');
        Route::patch('update', 'OpeningController@update');
    });

    // application routes
    Route::group(['prefix' => 'application'], function(){
        // create
        Route::group(['prefix' => 'create'], function(){
            Route::post('application', 'HiringApplicationController@createApplication');
        });

        // fetch
        Route::group(['prefix' => 'fetch'], function(){
            Route::get('hiringApplications', 'HiringApplicationController@fetchApplications');
        });
    });
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});
