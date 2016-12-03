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
});

Route::get('auth/basecamp', ['as' => 'auth.bcEndpoint', 'uses' => 'BasecampController@endpoint']);

Route::group(['prefix' => 'angular'], function(){
    Route::any('/{page}', ['as'=> 'angular', 'uses' => 'AngularController@view'])->where('page', '[a-zA-Z0-9_\.]+');

    Route::get('/{any}', 'AngularController@NoView')->where('any', '.*');
});

Route::put('project/join', ['as' => 'project.join', 'middleware' => ['auth'], 'uses' => 'BasecampController@join']);

Route::get('/profile/{user}/edit', ['as' => 'profile.edit', 'middleware' => ['basecamp', 'auth'], 'uses' => 'HomeController@index'])
    ->where('user', '[0-9]+');
Route::put('/profile', ['as' => 'profile.store', 'middleware' => ['basecamp', 'auth'], 'uses' => 'ProfileController@edit']);

Route::get('/{any?}', ['as' => 'home', 'middleware' => ['basecamp'], 'uses' => 'HomeController@index'])->where('any', '.*');
