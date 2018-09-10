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

Route::get('/', ['as' => 'index', 'uses' => 'IndexController@index']);

Route::post('/', ['as' => 'index', 'uses' => 'IndexController@index']);

Route::get('/category/{category}', ['as' => 'category', 'uses' => 'CategoryController@show']);

Route::get('/category/{parentCategory}/{category}', ['as' => 'subCategory', 'uses' => 'CategoryController@showSubCategory']);

Route::get('/product/{product}', ['as' => 'product', 'uses' => 'ProductController@show']);




