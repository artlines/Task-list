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

Route::get('/', 'TaskController');
Route::get('/api/v1/task', 'TaskController@getTasks');
Route::get('/api/v1/task/{id}', 'TaskController@getTaskById');
Route::post('/getTaskOne', 'TaskController@renderTaskOne');
