<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\MainCategory;
use App\Category;
use App\User;

class ApiController extends Controller
{
    
	public function getQuestionSets() {

		$sets = DB::table('sets')->orderBy('order', 'ASC')->get();
		
		$data = [];
		$i = 0;
		foreach ($sets as $key) {
			
			$data[$i]['id'] = $key->id;
			$data[$i]['setname'] = $key->setname;
			$data[$i]['slug'] = $key->slug;
			$data[$i]['link'] = url('/api/getQuestionsBySet/' . $key->id);
			$data[$i]['order'] = $key->order;
			$data[$i]['created_at'] = $key->created_at;

			$i++;
		}

		return response()->json([ 'data' => $data ]);

	}

	public function getQuestionsBySet(Request $request, $id) {

		$ques = DB::table('sets')->where('id', $id)->first();

		$level = $request->level;

		if ( $level && $level > 0 ) {
			$chklevel = $level;
		}else{
			$chklevel = "1";
		}

        $all = DB::table('question_sets')->select('category_id','no_of_question')->where('question_name', $ques->setname)->get();
        
        $data = [];
        foreach ( $all as $val ) {

        	$posts = DB::table('posts')->where('category_id', $val->category_id);

        	if ( $posts->count() > 0 ) {
        		if ( $val->no_of_question ) {
		            $data[] = DB::table('posts')->where('category_id', $val->category_id)
		            	->where('level', '<=', $chklevel)->inRandomOrder()->get()->take( $val->no_of_question )->toArray();
		          }
        	}

        }

        $filter = call_user_func_array('array_merge', $data);

		return response()->json( ['data' => $filter, 'questioncount' => count($filter) ]);

	}

	public function getCategories(){

		$cats = MainCategory::all();

		$data = [];
		$i = 0;
		foreach ($cats as $key) {
			
			$data[$i]['id'] = $key->id;
			$data[$i]['main_category_name'] = $key->main_category_name;
			$data[$i]['slug'] = $key->slug;
			$data[$i]['featured'] = $key->featured;
			$data[$i]['subcategories'] = url('/api/getSubCategoriesById/' . $key->id );

			$i++;
		}

		return response()->json(['data' => $data]);

	}

	public function getSubCategoriesById($id) {

		$cats = Category::where('main_category_id', $id)->get();

		$data = [];
		$i = 0;
		foreach ($cats as $key) {
			$data[$i]['id'] = $key->id;
			$data[$i]['main_category_id'] = $key->main_category_id;
			$data[$i]['category_name'] = $key->category_name;
			$data[$i]['slug'] = $key->slug;
			$data[$i]['link'] = url('/api/getQuestionsByCategory/' . $key->id);
		
			$i++;
		}
		return response()->json(['data' => $data]);

	}

	public function getQuestionsByCategory(Request $request, $id) {

		$level = $request->level;

		if ( $level && $level > 0 ) {
			$chklevel = $level;
		}else{
			$chklevel = "1";
		}

		$data = DB::table('posts')->where('level', '<=', $chklevel)
									->where('category_id', $id)
									->orderBy('id', 'DESC')
									->get();

		return response()->json( ['data' => $data] );							

	}

	public function updateUserLevel(Request $request) {

		$userId = $request->userId;
		$userLevel = $request->userLevel;

		$user = User::find( $userId );

		if ( $user ) {
			$user->level = $userLevel;
			$user->save();
		
			$msg = 'Congratulations! You have completed this level.';

		}else{
			$msg = 'User not found or some error.';
		}

		return response()->json( [
			'message' => $msg
		] );
		

	}

}