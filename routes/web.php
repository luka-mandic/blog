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

Route::get('/', 'PostsController@index')->name('home');

Auth::routes();

Route::resource('/posts', 'PostsController');


Route::post('/posts/{post}/comments', 'CommentsController@store');

Route::post('/posts/{post}/replies', 'RepliesController@store');

Route::get('/posts/tags/{tag}', 'TagsController@index');

Route::post('/posts/{post}/like', 'LikesController@storeLike');

Route::post('/posts/{post}/dislike', 'LikesController@storeDislike');