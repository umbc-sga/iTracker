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
    Route::post('project/{project}', ['as' => 'project', 'uses' => 'BasecampController@project'])
        ->where('project', '[0-9]+');
    Route::post('project/{project}/people', ['as' => 'peopleInProject', 'uses' => 'BasecampController@peopleInProject'])
            ->where('project', '[0-9]+');
    Route::post('project/{project}/events/{page?}', ['as' => 'projectEvents', 'uses' => 'BasecampController@projectEvents'])
        ->where('project', '[0-9]+')
        ->where('page', '[1-9]+[0-9]*');


    Route::post('people', ['as' => 'people', 'uses' => 'BasecampController@people']);
    Route::post('person/{person}', ['as' => 'person', 'uses' => 'BasecampController@person'])
        ->where('person', '[0-9]+');
    Route::post('person/{person}/projects', ['as' => 'personProjects', 'uses' => 'BasecampController@personProject'])
        ->where('person', '[0-9]+');

    Route::post('groups', ['as' => 'groups', 'uses' => 'BasecampController@groups']);
    Route::post('group/{group}', ['as' => 'group', 'uses' => 'BasecampController@group'])
        ->where('group', '[0-9]+');
    Route::post('dept/{dept}', ['as' => 'dept', 'uses' => 'BasecampController@dept']);
    Route::post('dept/{dept}/projects', ['as' => 'deptProjects', 'uses' => 'BasecampController@deptartmentProjects']);


    Route::post('todos/{status?}', ['as' => 'todos', 'uses' => 'BasecampController@todos']);
});

Route::any('/{any}', 'APIController@NoAPIResponse')->where('any', '.*');
