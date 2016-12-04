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
    Route::post('project/{project}/todos', ['as' => 'projectTodos', 'uses' => 'BasecampController@todos'])
        ->where('project', '[0-9]+');
    Route::post('project/{project}/history', ['as' => 'projectHistory', 'uses' => 'BasecampController@history'])
        ->where('project', '[0-9]+');
    Route::post('project/{project}/picture', ['as' => 'projectImage', 'middleware' => ['web', 'auth'], 'uses' => 'ProjectController@imageUpload'])
        ->where('project', '[0-9]+');
    Route::post('project/{project}/events/{page?}', ['as' => 'projectEvents', 'uses' => 'BasecampController@projectEvents'])
        ->where('project', '[0-9]+')
        ->where('page', '[1-9]+[0-9]*');


    Route::post('people', ['as' => 'people', 'uses' => 'BasecampController@people']);
    Route::post('person/{person}', ['as' => 'person', 'uses' => 'BasecampController@person'])
        ->where('person', '[0-9]+');
    Route::post('person/{person}/projects', ['as' => 'personProjects', 'uses' => 'BasecampController@personProject'])
        ->where('person', '[0-9]+');
    Route::post('person/{person}/profile', ['as' => 'personProjects', 'uses' => 'ProfileController@profile'])
        ->where('person', '[0-9]+');

    Route::post('groups', ['as' => 'groups', 'uses' => 'BasecampController@groups']);
    Route::post('group/{group}', ['as' => 'group', 'uses' => 'BasecampController@group'])
        ->where('group', '[0-9]+');
    Route::post('dept/{dept}', ['as' => 'dept', 'uses' => 'BasecampController@dept']);
    Route::post('dept/{dept}/projects', ['as' => 'deptProjects', 'uses' => 'BasecampController@deptartmentProjects']);
    Route::put('dept/{dept}/makeExec/{person}', ['middleware' => ['web', 'auth'], 'uses' => 'DepartmentController@makeExec'])
        ->where('dept', '[0-9]+')
        ->where('person', '[0-9]+');
    Route::put('dept/{dept}/makeCabinet/{person}', ['middleware' => ['web', 'auth'], 'uses' => 'DepartmentController@makeCabinet'])
        ->where('dept', '[0-9]+')
        ->where('person', '[0-9]+');
    Route::put('dept/{dept}/profileEdit', ['middleware' => ['web', 'auth'], 'uses' => 'DepartmentController@editProfile'])
        ->where('dept', '[0-9]+');

    Route::put('profileStore', ['as' => 'profile.store', 'middleware' => ['web', 'auth'], 'uses' => 'ProfileController@edit']);
    Route::put('profileStore', ['as' => 'profile.store', 'middleware' => ['web', 'auth'], 'uses' => 'ProfileController@edit']);
    Route::post('currentUser', ['as' => 'currentUser', 'middleware' => ['web', 'auth'], 'uses' => 'APIController@currentUser']);

    Route::post('/', ['as' => 'root', 'uses' => 'APIController@NoAPIResponse']);
});

Route::any('/{any}', 'APIController@NoAPIResponse')->where('any', '.*');
