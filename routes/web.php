<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

/**
 * Authentication
 */
Route::group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'Auth'], function(){
    Route::get('/login', ['as' => 'login', 'uses' => 'AuthController@login']);
    Route::get('/logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);
    Route::get('/callback', ['as' => 'callback', 'uses' => 'AuthController@callback']);
    Route::get('/basecamp', ['as' => 'bcEndpoint', 'uses' => 'BasecampController@endpoint']);
});

Route::group(['prefix' => 'angular'], function(){
    Route::any('/{page}', ['as'=> 'angular', 'uses' => 'AngularController@view']);

    Route::get('/{any}', 'AngularController@NoView')->where('any', '.*');
});

Route::put('project/join', ['as' => 'project.join', 'middleware' => ['auth'], 'uses' => 'BasecampController@join']);

Route::get('/{any?}', ['as' => 'home', 'middleware' => ['basecamp'], 'uses' => 'HomeController@index'])->where('any', '.*');
