<?php

Auth::routes();

Route::get('/quiz-sets', 'HomeController@quiz_sets')->name('quiz.sets');
Route::get('/view-set/{slug}/{page}', 'HomeController@set_view')->name('set.view');
Route::get('/view-set/page/{setid}/{page}', 'HomeController@set_next_page')->name('set.next');
Route::post('/change_order', 'CategoryController@change_order')->name('change.order');


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

Route::get('/{main}/{slug}/{id}/{page}', 'CategoryController@cat')->name('cat');
Route::get('/posts/{id}/edit', 'PostsController@edit')->name('posts');
Route::post('posts/update/', 'PostsController@update');

Route::post('/uploadFile', 'UploadPostController@uploadFile');
Route::post('/uploadCategory', 'UploadPostController@uploadCategory');
// online test
Route::get('/online-test/{slug}/{id}', 'CategoryController@online_test')->name('online_test');
// Route::post('/category/{id}/validate', 'CategoryController@validate_test');
Route::get('/test-online/{set}/{id}', 'CategoryController@online_test_set')->name('test.set');

Route::get('/update/user/level/', 'CategoryController@update_user_level')->name("update.user.level");
Route::get('/update/userranking', 'CategoryController@update_user_ranking');

Route::put('/maincategory/{id}/edit', 'MainCategoryController@featured_cat');
Route::put('/category/{id}/edit', 'CategoryController@featured_cat');

Route::post('posts/report_post/{id}', 'PostsController@report_post');
Route::get('posts/question_report', 'PostsController@show');

Route::get('/{slug}/{id}', 'MainCategoryController@index');

Route::post('/posts/score', 'PostsController@score');

// tems
Route::get('/list-all', 'HomeController@list_all');
Route::get('new/online-quiz/{slug}/{id}', 'CategoryController@new_test');

Route::post('/category/validate_test', 'CategoryController@validate_test');

// upload excel
Route::post('/uploadFile2', 'UploadPostController@uploadFile');
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
Route::get('question_sets', 'CategoryController@set_index')->name('sets');
Route::get('/create_question_sets', 'CategoryController@create_set')->name('question');
Route::post('/store_question_sets', 'CategoryController@store_questionsets');
Route::get('/question_set/edit/{id}', 'CategoryController@edit_questionsets')->name("questionset.edit");
Route::put('/question_set/update/{id}', 'CategoryController@update_questionsets')->name('questionset.update');
Route::get('/question_set/remove/{id}', 'CategoryController@destroy_questionsets')->name('questionset.destroy');

Route::get('rankings', 'CategoryController@rankings')->name('rankings');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('index');
