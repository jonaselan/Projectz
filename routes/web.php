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
    Route::post('/projects', 'ProjectController@store')->name('projects.store');
    Route::get('/projects/create', 'ProjectController@create')->name('projects.create');
    Route::get('/projects', 'ProjectController@index')->name('projects.index');
    Route::get('/projects/{project}', 'ProjectController@show')->name('projects.show');

    Route::get('/home', 'HomeController@index')->name('home');
});

Auth::routes();

