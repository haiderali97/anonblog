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

Route::redirect('/','/home',301);
Route::get('/home','HomeController@Home')->name('home');
Route::post('/home','HomeController@post')->name('home.post');
Route::get('/{blog_id}/{blog_slug}','BlogController@view')->name('blog.view');
Route::get('/{blog_id}/{blog_slug}/edit','BlogController@editPrompt')->name('edit.prompt');
Route::post('/{blog_id}/{blog_slug}/edit','BlogController@editPromptPost')->name('edit.prompt.post');
Route::get('/{blog_id}/{blog_slug}/editPost','BlogController@editBlog')->name('edit.blog');
Route::post('/{blog_id}/{blog_slug}/editPost','BlogController@editBlogPost')->name('edit.blog.post');

