<?php

use Illuminate\Support\Facades\Route;

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

Route::get('search', 'SearchController@posts')->name('search.posts');

Route::prefix('posts')->middleware('auth')->group(function() {
  Route::get('create', 'PostController@create')->middleware('auth')->name('posts.create');
  Route::post('store', 'PostController@store');
  Route::get('{post:slug}/edit', 'PostController@edit');
  Route::patch('{post:slug}/edit', 'PostController@update');
  Route::delete('{post:slug}/delete', 'PostController@destroy');
});

Route::get('posts', 'PostController@index')->name('posts.index');
Route::get('posts/{post:slug}', 'PostController@show')->name('posts.show');

Route::get('categories/{category:slug}', 'CategoryController@show')->name('categories.show');
Route::get('tags/{tag:slug}', 'TagController@show')->name('tags.show');

Route::view('contact', 'contact');
Route::view('about', 'about');
Route::view('login', 'login');
Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
