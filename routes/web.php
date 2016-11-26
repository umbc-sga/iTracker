<?php

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

Route::get('/{any}', ['as' => 'home', 'uses' => 'HomeController@index'])->where('any', '.*');
