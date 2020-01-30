<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\MainCategory;
use App\Category;
use App\User;
use App\ComprehensiveCategories;
use App\Paragraph;

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

        $para = DB::table('question_sets')->select('no_of_question')->where('question_name', $ques->setname)->where('category_id', 1000)->first();
        
        $filter2 = [];
        if ( $para ) {
        	
        	$comprehensive = Paragraph::where('level', '<=', $chklevel)->inRandomOrder()->get()->take( $para->no_of_question );


        	if ( count( $comprehensive ) > 0 ) {

	        	foreach ($comprehensive as $key => $value) {
	        		
	        		$filter2[$key] = $value;

	        		$select = [
							'posts.id', 'post_name', 'category_name', 'option_a', 'option_b',
							'option_c', 'option_d', 'correct_option', 'explanation', 'level',
							'posts.created_at', 'posts.updated_at'
						];

					$allposts = $value->posts()->select( $select )
										->where('level', '<=', $chklevel)
										->get();

	        		$filter2[$key]['questions'] = $allposts;
	        		$filter2[$key]['category_id'] = 1000;
	        		$filter2[$key]['post_name'] = '';
	        		$filter2[$key]['featured'] = NULL;
	        		$filter2[$key]['category_name'] = '';
	        		$filter2[$key]['option_a'] = '';
	        		$filter2[$key]['option_b'] = '';
	        		$filter2[$key]['option_c'] = '';
	        		$filter2[$key]['option_d'] = '';
	        		$filter2[$key]['correct_option'] = '';
	        		$filter2[$key]['explanation'] = '';

	        		$filter2[$key]->type = "1"; 


	        	}
        	}

        }

        $data = [];
        foreach ( $all as $val ) {

        	$posts = DB::table('posts')->where('category_id', $val->category_id);

        	if ( $posts->count() > 0 ) {
        		if ( $val->no_of_question && $val->category_id !== 1000 ) {
		            $data[] = DB::table('posts')->where('category_id', $val->category_id)
		            	->where('level', '<=', $chklevel)->inRandomOrder()->get()->take( $val->no_of_question );
		          }
        	}

        }

		$filter1 = collect( $data )->flatten();
		
		$filter = [];$cc = 0;
        foreach ($filter1 as $key => $value) {
        	$filter[$cc]['id'] = $value->id;
        	$filter[$cc]['comprehensive_categories_id'] = '';
        	$filter[$cc]['title'] = '';
        	$filter[$cc]['paragraph'] = '';
        	
        	$filter[$cc]['user_id'] = $value->user_id;
        	$filter[$cc]['level'] = $value->level;
        	$filter[$cc]['created_at'] = $value->created_at;
        	$filter[$cc]['updated_at'] = $value->updated_at;

        	$filter[$cc]['questions'] = [];

        	$filter[$cc]['category_id'] = $value->category_id;
        	$filter[$cc]['post_name'] = $value->post_name;
        	$filter[$cc]['featured'] = $value->featured;
        	$filter[$cc]['category_name'] = $value->category_name;
        	$filter[$cc]['option_a'] = $value->option_a;
        	$filter[$cc]['option_b'] = $value->option_b;
        	$filter[$cc]['option_c'] = $value->option_c;
        	$filter[$cc]['option_d'] = $value->option_d;
        	$filter[$cc]['correct_option'] = $value->correct_option;
        	$filter[$cc]['explanation'] = $value->explanation;

        	$filter[$cc]['type'] = 0;

        	$cc++;
        }

        if ( $filter2 ) {
        	return response()->json( ['data' => array_merge( $filter2 , $filter), 'questioncount' => count(array_merge( $filter2 , $filter)) ]);
        }else{
        	return response()->json( ['data' => $filter, 'questioncount' => count($filter) ]);
        }

	}

	public function getCategories(){

		// Check tbl_menu
		$menu = DB::table('tbl_menu')->get()->count();

		if ( $menu > 0 ) {
			
			$menu = DB::table('tbl_menu')->get();
			$data = [];$i=0;
			foreach ($menu as $cat) {

				
				if ( $cat->slugs == 'comprehensive' ) {
					$data[$i]['id'] = 1000;
					$data[$i]['main_category_name'] = 'Comprehensive;';
					$data[$i]['slug'] = 'comprehensive';
					$data[$i]['featured'] = 1;
					$data[$i]['subcategories'] = url('/api/getComprehensiveCategories');
				}
				if ( $cat->slugs !== 'comprehensive' ) {
					// Get category by slug
					$temp = MainCategory::where('slug', $cat->slugs)->first();
					$data[$i]['id'] = $temp->id;
					$data[$i]['main_category_name'] = $temp->main_category_name;
					$data[$i]['slug'] = $temp->slug;
					$data[$i]['featured'] = $temp->featured;
					$data[$i]['subcategories'] = url('/api/getSubCategoriesById/' . $temp->id );
				}

				$i++;

				}
				
			return response()->json(['data' => $data]);
				
		}else{

			$cats = MainCategory::all();

			$data = [];

			$data[0]['id'] = 1000;
			$data[0]['main_category_name'] = 'Comprehensive;';
			$data[0]['slug'] = 'comprehensive';
			$data[0]['featured'] = 1;
			$data[0]['subcategories'] = url('/api/getComprehensiveCategories');

			$i = 1;
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

		

	}

	public function getComprehensiveCategories(){

		$cats = ComprehensiveCategories::orderBy('id', 'DESC')->get();

		if ( count($cats) == 0 ) {
			return response()->json(['message' => 'No categories at the moment.']);
		}

		$data = [];
		$i = 0;
		foreach ($cats as $key) {
			
			$data[$i]['id'] = $key->id;
			$data[$i]['main_category_id'] = 1000;
			$data[$i]['category_name'] = $key->title;
			$data[$i]['slug'] = $key->slug;
			$data[$i]['link'] = url('/api/getParagraphsByCategory/' . $key->id);

			$i++;
		}

		return response()->json(['data' => $data]);

	}

	public function getParagraphsByCategory(Request $request, $id){

		$level = $request->level;

		if ( $level && $level > 0 ) {
			$chklevel = $level;
		}else{
			$chklevel = "1";
		}
		
		$paragraphs = Paragraph::where('comprehensive_categories_id', $id)
								->orderBy('id', 'DESC')
								->where('level', '<=', $chklevel)
								->get();

		$data = [];
		$i = 0;
		if ( count($paragraphs) > 0 ) {
			
			foreach ($paragraphs as $key) {
				
				$data[$i]['id'] = $key->id;
				$data[$i]['title'] = $key->title;
				$data[$i]['paragraph'] = $key->paragraph;

				$select = [
							'posts.id', 'post_name', 'category_name', 'option_a', 'option_b',
							'option_c', 'option_d', 'correct_option', 'explanation', 'level',
							'posts.created_at'
						];

				$allposts = $key->posts()->select( $select )
										->where('level', '<=', $chklevel)
										->get();

				$data[$i]['questions'] = $allposts;

				$i++;
			}

			return response()->json(['data' => $data]);

		}else{

			return response()->json(['message' => "There are no questions at the moment."]);

		}

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