<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/questionSets', function(){
	$posts = App\Posts::all();
	return $posts;
});

Route::post('userLogin', 'ApiAuth\LoginController@login');

Route::get('/getQuestionSets', 'ApiController@getQuestionSets');

Route::get('/getCategories', 'ApiController@getCategories');

Route::get('/getSubCategoriesById/{id}', 'ApiController@getSubCategoriesById');

Route::get('/getQuestionsBySet/{id}', 'ApiController@getQuestionsBySet');

Route::get('/getQuestionsByCategory/{id}', 'ApiController@getQuestionsByCategory');

Route::post('/updateUserLevel', 'ApiController@updateUserLevel');

Route::get('/getComprehensiveCategories', 'ApiController@getComprehensiveCategories');

Route::get('/getParagraphsByCategory/{id}', 'ApiController@getParagraphsByCategory');