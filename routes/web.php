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

Route::group(['prefix' => 'angular'], function(){
    Route::any('/{page}', ['as'=> 'angular', 'uses' => 'AngularController@view']);

    Route::get('/{any}', 'AngularController@NoView')->where('any', '.*');
});

Route::get('oauth/endpoint', ['as' => 'bcEndpoint', 'uses' => 'BasecampController@endpoint']);

Route::get('/{any?}', ['as' => 'home', 'middleware' => ['basecamp'], 'uses' => 'HomeController@index'])->where('any', '.*');
