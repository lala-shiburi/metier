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

    Route::group(['prefix' => "company"], function(){
        Route::post('create', 'CompanyController@create');
        Route::get('fetch','CompanyController@fetch');
        Route::get('fetch/openings','CompanyController@fetch_openings');
        Route::get('datatable','CompanyController@fetch_datatable');
    });

    Route::group([ "prefix" => "opening" ], function(){
        Route::group(["prefix" => "validate"],function(){
            Route::post('basicInfo','OpeningController@validateBasicInfo');
            Route::post('description','OpeningController@validateDescription');
        });
        
        Route::post('create','OpeningController@create');
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
