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

    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');

    Route::group(["prefix" => "user"], function(){
        Route::get('/', function(Request $request){
            return $request->user();
        });

        // fetch
        Route::group(["prefix"=>"fetch"], function(){
            Route::group(["prefix" => "openings"], function(){
                Route::get('/', 'UserController@fetchOpenings');
                Route::get('saved', "UserController@fetchSavedOpenings");
            });
            Route::group(["prefix" => "companies"], function(){
                Route::get('managed', 'UserController@fetchManagedCompanies');
                Route::get('saved/users', 'CompanyController@fetchSavedUsers');
            });
        });

        // update
        Route::group(["prefix" => "update"], function(){
            // opening
            Route::group(["prefix"=>"opening"], function(){
                Route::patch('save', 'UserController@saveOpening');
            });
        });
    });

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
            Route::post('work_experience', 'UserController@update_work_experience');
            Route::post('education_background', 'UserController@update_education_background');
            Route::post('user_description', 'UserController@update_description');
            Route::post('basic_info', 'UserController@update_basic_info');
            Route::patch('photo', 'UserController@updatePhoto');
            Route::patch('cover', 'UserController@updateCover');
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

        // fetch
        Route::group(['prefix'=>'fetch'], function(){
            Route::get('applications', 'CompanyController@fetchHiringApplications');
            Route::get('hiring/applications2', 'CompanyController@fetchHiringApplications2');
            Route::get('collaborators', 'CompanyController@fetchCollaborators');
            Route::get('isBookMarked', 'CompanyController@fetchIsBookMarked');
            Route::group(['prefix' => 'applicants'], function(){
                Route::get('lazy_load', 'CompanyController@lazyFetchHiringApplication');
            });
            Route::get('managed/companies', 'UserController@fetch_companies');
        });

        // add
        Route::group(['prefix'=>'add'], function(){
            Route::post('collaborator','CompanyController@addCollaborator');
        });

        // save
        Route::group(['prefix'=>'save'], function(){
            Route::post('user', 'CompanyController@saveUser');
        });

        // delete
        Route::group(['prefix'=>'delete'], function(){
            Route::delete('collaborator','CompanyController@removeCollaborator');
        });

        // update
        Route::group(['prefix' => 'update'], function(){
            Route::patch('basic/info', 'CompanyController@updateBasicInfo');
            Route::patch('website/info', 'CompanyController@updateWebsiteInfo');
            Route::patch('photo', 'CompanyController@updatePhoto');
            Route::patch('cover', 'CompanyController@updateCover');
            Route::patch('introduction', 'CompanyController@updateIntroduction');
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

        // validate
        Route::group(["prefix" => "validate"],function(){
            Route::post('basicInfo', 'OpeningController@validateBasicInfo');
            Route::post('description', 'OpeningController@validateDescription');
        });

        // delete
        Route::group(["prefix" => "delete"], function(){
            Route::delete('soft', 'OpeningController@softDelete');
        });

        // update
        Route::group(["prefix" => "update"], function(){
            Route::patch('/', 'OpeningController@update');
        });
        
        Route::post('create', 'OpeningController@create');
    });

    // application routes
    Route::group(['prefix' => 'application'], function(){
        // fetch
        Route::group(['prefix' => 'fetch'], function(){
            Route::get('hiringApplications', 'HiringApplicationController@fetchApplications');
            Route::get('one', 'HiringApplicationController@fetchOneApplication');
            Route::get('hiring/step/results', 'HiringApplicationController@fetchApplicationStepAndResults');
            Route::get('results', 'HiringApplicationController@fetchApplicationResults');
        });

        // update
        Route::group(['prefix'=>'update'], function(){
            Route::patch('dismiss', 'HiringApplicationController@dismissApplication');
        });
    });

    // notification routes
    Route::group(['prefix' => 'notification'], function(){
        // fetch
        Route::group(['prefix'=>'fetch'], function(){
            Route::get('/', 'NotificationController@fetchNotifications');
            Route::get('one', 'NotificationController@fetchNotification');
            Route::get('more', 'NotificationController@fetchMoreNotifications');
            Route::get('unread/count', 'NotificationController@fetchUnreadNotificationCount');
        });
        // update
        Route::group(['prefix'=>'update'], function(){
            Route::patch('mark_read_all', 'NotificationController@markReadAll');
        });
    });

    // reporting routes
    Route::group(['prefix' => 'reporting'], function(){
        // recruiter
        Route::group(['prefix'=>'recruiter'], function(){
            Route::get('companies', 'ReportController@fetch_companies');
            Route::get('application/count', 'ReportController@fetchApplicationCount');
            Route::get('opening/count', 'ReportController@fetchOpeningCount');
            Route::get('application/count/per/company', 'ReportController@fetchApplicationCountPerCompany');
            Route::get('application/count/per/day', 'ReportController@fetchApplicationChartDataPerDay');
        });
        // applicant
        Route::group(['prefix'=>'applicant'], function(){
            Route::get('application/count', 'ReportController@fetchApplicantApplicationCount');
            Route::get('followed/companies', 'ReportController@fetchFollowedCompanies');
            Route::get('recent/applications', 'ReportController@fetchRecentApplications');
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

/**
 * public accessible
 */
// opening
Route::group([ "prefix" => "opening" ], function(){
    // fetch
    Route::group(['prefix'=>'fetch'], function(){
        Route::get('/', 'OpeningController@fetch');
        Route::get('/raw', 'OpeningController@fetchRaw');
        Route::post('search', 'OpeningController@search');
        Route::get('/recent', 'OpeningController@fetchRecentApplication');
    });
});
//company
Route::group(['prefix' => "company"], function(){
    Route::group(['prefix'=>'fetch'], function(){
        Route::get('/', 'CompanyController@fetch');
        Route::post('search', 'CompanyController@fetchCompanySearch');
        Route::get('openings', 'CompanyController@fetch_openings');
        Route::get('popular', 'CompanyController@fetchPopularCompanies');
    });
});
//user
Route::group(['prefix'=>'user'], function(){
    // fetch
    Route::group(['prefix'=>'fetch'], function(){
        Route::post('search', 'UserController@searchUser');
    });
});
// applications
Route::group(['prefix'=>'application'], function(){
    // validation
    Route::group(['prefix'=>'validate'], function(){
        Route::post('guest/onsite/registration/validation', 'HiringApplicationController@guestOnsiteRegistrationValidate');
    });
    // file upload
    Route::group(['prefix'=>'upload'], function(){
        Route::post('resume_file', 'HiringApplicationController@uploadTempResumeFile');
    });
    // create
    Route::group(['prefix' => 'create'], function(){
        Route::post('application', 'HiringApplicationController@createApplication');
    });
});
