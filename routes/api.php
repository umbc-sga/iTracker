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

Route::group(['prefix' => 'v1', 'as' => 'api.v1.', 'middleware' => ['basecamp']], function(){
    Route::post('projects', ['as' => 'projects', 'uses' => 'BasecampController@projects']);
    Route::post('project/{project}', ['as' => 'projects', 'uses' => 'BasecampController@project'])
        ->where('project', '[0-9]+');
    Route::post('project/{project}/people', ['as' => 'projects', 'uses' => 'BasecampController@peopleInProject'])
            ->where('project', '[0-9]+');
    Route::post('project/{project}/events/{page?}', ['as' => 'projects', 'uses' => 'BasecampController@projectEvents'])
        ->where('project', '[0-9]+')
        ->where('page', '[1-9]+[0-9]*');

    Route::post('people', ['as' => 'people', 'uses' => 'BasecampController@people']);
    Route::post('person/{person}/info', ['as' => 'people', 'uses' => 'BasecampController@personInfo'])
        ->where('person', '[0-9]+');
    Route::post('person/{person}/projects', ['as' => 'people', 'uses' => 'BasecampController@personProject'])
        ->where('person', '[0-9]+');

    Route::post('groups', ['as' => 'people', 'uses' => 'BasecampController@groups']);
    Route::post('group/{group}', ['as' => 'people', 'uses' => 'BasecampController@group'])
        ->where('group', '[0-9]+');
    Route::post('dept/{dept}', ['as' => 'people', 'uses' => 'BasecampController@dept']);
    Route::post('dept/{dept}/projects', ['as' => 'people', 'uses' => 'BasecampController@deptProjects']);

    Route::post('todos/{status?}', ['as' => 'people', 'uses' => 'BasecampController@todos']);
});

Route::any('/{any}', 'APIController@NoAPIResponse')->where('any', '.*');
