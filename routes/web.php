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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();



Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('index');
Route::get('/dashboard', 'HomeController@dash')->name('dash');
Route::get('posts/index', 'PostsController@index')->name('postindex');
Route::get('category/index', 'CategoryController@index');

Route::resource('posts', 'PostsController');
Route::resource('maincategory', 'MainCategoryController');

// Route::get('posts/create', 'PostsController@create');
Route::get('category/create', 'CategoryController@create');

Route::post('category/store', 'CategoryController@store');

Route::delete('/category/{id}/delete', 'CategoryController@destroy');

// Route::get('/{slug}/main', 'MainCategoryController@show');

Route::get('/{main}/{slug}/{id}', 'CategoryController@cat')->name('cat');
Route::get('/posts/{id}/edit', 'PostsController@edit')->name('posts');
Route::post('posts/update/', 'PostsController@update');

Route::post('/uploadFile', 'UploadPostController@uploadFile');
Route::post('/uploadCategory', 'UploadPostController@uploadCategory');
// online test
Route::get('/online-test/{slug}/{id}', 'CategoryController@online_test')->name('online_test');
// Route::post('/category/{id}/validate', 'CategoryController@validate_test');

Route::put('/maincategory/{id}/edit', 'MainCategoryController@featured_cat');
Route::put('/category/{id}/edit', 'CategoryController@featured_cat');

Route::post('posts/report_post/{id}', 'PostsController@report_post');
Route::get('posts/question_report', 'PostsController@show');

// online test
Route::get('/test/online/{slug}/{id}', 'CategoryController@test')->name('test'); 


Route::get('test/online-quiz/{slug}/{id}', 'CategoryController@online_quiz')->name('online-quizz');


Route::get('/{slug}/{id}', 'MainCategoryController@index');

Route::post('/posts/score', 'PostsController@score');

// temp
Route::get('/list-all', 'HomeController@list_all');
Route::get('new/online-quiz/{slug}/{id}', 'CategoryController@new_test');

Route::post('/category/validate_test', 'CategoryController@validate_test');

// upload excel
Route::post('/uploadFile2', 'UploadPostController@uploadFile2');
Route::post('/uploadFilee', 'UploadPostController@uploadFilee');

// facebook login - it works
Route::get('/redirectfb', 'SocialAuthFacebookController@redirect')->name('fb_redirect');
Route::get('/callback', 'SocialAuthFacebookController@callback');

// test, not working
Route::get('login/facebook', 'Auth\LoginController@redirectToFacebookProvider')->name('facebook.login');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

// goolge login
Route::get('/redirectgoogle', 'SocialAuthGoogleController@redirect')->name('google_redirect')->name('google_redirect');
Route::get('/google_callback', 'SocialAuthGoogleController@callback');

// create set
Route::get('/create_question_sets', 'CategoryController@create_set')->name('question');
Route::post('/store_question_sets', 'CategoryController@store_questionsets');
