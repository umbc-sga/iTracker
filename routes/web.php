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

Route::any('angular/{page}', ['as'=> 'angular', 'uses' => 'AngularController@view']);

Route::get('/{any}', ['as' => 'home', 'uses' => 'HomeController@index'])->where('any', '.*');