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


Route::get('/create', 'DemoController@create')->name('create');
Route::get('/', 'DemoController@index')->name('index');
Route::post('/newpost', 'DemoController@newpost')->name('newpost');
Route::get('/show/{id}', 'DemoController@show')->name('show');
Route::get('/category/{id}', 'DemoController@bycategory')->name('category');
Route::get('/tag/{id}', 'DemoController@bytag')->name('tag');
Route::get('/edit/{id}', 'DemoController@edit')->name('edit');
Route::post('/update', 'DemoController@update')->name('update');
Route::get('/destroy/{id}', 'DemoController@destroy')->name('destroy');

