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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'HomeController@allUsers')->name('user.all');
Route::get('/users/create', 'HomeController@createUser')->name('user.create');
Route::get('/users/changerole', 'HomeController@changeUserRole')->name('user.changerole');


Route::get('/writer', 'HomeController@writerIndex')->name('writer.home');
Route::get('/posts', 'HomeController@allPosts')->name('post.all');
Route::get('/posts/create', 'HomeController@createPost')->name('post.create');
Route::get('/posts/{post}', 'HomeController@viewPosts')->name('post.view');
