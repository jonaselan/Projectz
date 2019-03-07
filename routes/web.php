<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'projects'], function() {
        Route::get('', 'ProjectController@index')->name('projects.index');
        Route::get('/create', 'ProjectController@create')->name('projects.create');
        Route::post('', 'ProjectController@store')->name('projects.store');
        Route::get('/{project}', 'ProjectController@show')->name('projects.show');

        Route::post('/{project}/tasks', 'TaskController@store')->name('projects.tasks.store');
        Route::patch('/projects/{project}/tasks/{task}', 'TaskController@update')->name('projects.tasks.update');
    });

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();

