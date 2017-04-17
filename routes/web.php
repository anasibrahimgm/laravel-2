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

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web"  middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => 'web'], function() {
	//domain.app/blog/slug-goes-here
	Route::get('blog/{slug}', ['as' =>  'blog.single', 'uses' => 'BlogController@getSingle'])->where('slug', '[\w\d\-\_]+');//any word-any number-dash-underscore "+": any number of them
	Route::get('blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);

	Route::get('/contact', 'PagesController@getContact');
	Route::get('/about', 'PagesController@getAbout');
	Route::get('/', 'PagesController@getIndex');

	Route::resource('/posts','PostController');
});
