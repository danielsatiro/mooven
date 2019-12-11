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

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
Route::get('/repos/search', ['as' => 'repos.search', 'uses' => 'RepositoryController@search']);
Route::post('/repos/{user}', ['as' => 'repos.store', 'uses' => 'RepositoryController@store']);
Route::delete('/repos/{id}', ['as' => 'repos.destroy', 'uses' => 'RepositoryController@destroy']);

Route::get('/users/{user}/repos', ['as' => 'users.repos', 'uses' => 'UserController@index']);
