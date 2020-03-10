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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Routes for categories
Route::get('/', 'CategoryController@listCategories')->name('categoryView');
Route::post('category/store', 'CategoryController@store')->name('categories.store');
Route::post('category/update', 'CategoryController@update')->name('categories.update');
Route::get('category/{id}/delete', 'CategoryController@destroy')->name('categories.delete');
Route::post('permisson/update', 'CategoryController@editPermisson')->name('permissions.update');

//Routes for files
Route::get('document/{file_name}/download', 'DocumentsController@download')->name('document.download');
Route::post('document/upload', 'DocumentsController@store')->name('documents.upload');

