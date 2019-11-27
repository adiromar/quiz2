<?php

Auth::routes();
Route::get('payment/create', 'PageController@create_payment')->name('payment');
Route::post('payment/store', 'PageController@store_payment')->name('payment.store');
Route::resource('courses', 'CourseController')->except(['destroy']);
Route::get('courses/delete/{id}', 'CourseController@destroy')->name('courses.destroy');

Route::get('topics', 'TopicController@index')->name('topics.index');
Route::post('topics', 'TopicController@store')->name('topics.store');
Route::get('topics/{id}', 'TopicController@destroy')->name('topics.destroy');

Route::get('book/topics', 'PageController@topics')->name('topics');
Route::get('book/courses/{slug}', 'PageController@topic_view')->name('topic.view');
Route::get('book/course/{slug}', 'PageController@course_view')->name('course.view');
Route::get('video', 'CourseController@video_create')->name('video.create');
Route::post('video', 'CourseController@video_store')->name('videos.store');
Route::get('videos', 'PageController@videos')->name('videos');
Route::get('classroom/video/{slug}', 'PageController@video_show')->name('video.show');
Route::get('payments/report', 'HomeController@payments_report')->name('payment.receipts');

Route::get('/quiz-sets', 'HomeController@quiz_sets')->name('quiz.sets');
Route::get('/view-set/{slug}/{page}', 'HomeController@set_view')->name('set.view');
Route::get('/view-set/page/{setid}/{page}', 'HomeController@set_next_page')->name('set.next');
Route::post('/change_order', 'CategoryController@change_order')->name('change.order');


Route::get('/dashboard', 'HomeController@dash')->name('dash');
Route::get('posts/index', 'PostsController@index')->name('postindex');
Route::get('category/index', 'CategoryController@index');

Route::resource('posts', 'PostsController');
Route::get('comprehensive', 'PostsController@comprehensive_question')->name('posts.comprehensive');
Route::get('comprehensive/create', 'PostsController@create_comprehensive_questions')->name('comprehensive.create');
Route::post('comprehensive/store', 'PostsController@comprehensive_store')->name('comprehensive.store');
Route::get('comprehensive/categories', 'PostsController@comprehensive_categories')->name('comprehensive.categories');
Route::post('comprehensive/category/store','PostsController@comprehensive_category_store')->name('comprehensive.category.store');
Route::resource('maincategory', 'MainCategoryController');
Route::get('stats', 'PostsController@stats')->name('stats');
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
Route::post('/uploadFile2', 'UploadPostController@import')->name('upload.excel');
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
