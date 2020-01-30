<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\MainCategory;
use App\Category;
use App\Posts;
use DB;

class UsersController extends Controller
{
    public function __construct() {
    	$this->middleware('auth');
    }

	public function index() {

		$users = User::orderBy('id', 'DESC')->get();

		return view('user.index')->with('users', $users);

	}

	public function update_role($id, $action) {
		
		if ( $action == "promote" ) {
			
			$affected = DB::table('role_user')
              ->where('user_id', $id)
              ->update(['role_id' => 1]);

		}else{

			$affected = DB::table('role_user')
              ->where('user_id', $id)
              ->update(['role_id' => 2]);

		}

		return redirect()->back();

	}

	public function manage_menu() {

		$main = MainCategory::orderBy('id', 'DESC')->get();

		$subs = Category::orderBy('id', 'DESC')->get();

		$menutype_comp = DB::table('tbl_menu')->where('category_type', 'comp')->first();
		$menutype_main = DB::table('tbl_menu')->where('category_type', 'main')->pluck('slugs')->toArray();
		$menutype_sub = DB::table('tbl_menu')->where('category_type', 'sub')->pluck('slugs')->toArray();
		
		return view('user.menu')->with('main', $main)
								->with('subs', $subs)
								->with('menutype_comp', $menutype_comp)
								->with('menutype_main', $menutype_main)
								->with('menutype_sub', $menutype_sub);

	}

	public function store_menu(Request $request) {


		if ( $request->comp || $request->main || $request->subs ) {
			DB::table('tbl_menu')->truncate();
		}

		if ( $request->comp ) {
			
			$data = [
						'slugs' => 'comprehensive',
						'category_type' => 'comp'
					];

			DB::table('tbl_menu')->insert($data);


		}

		if ( $request->main ) {
			
			foreach ($request->main as $main) {
				
				$data = [
							'slugs' => $main,
							'category_type' => 'main'
						];

				DB::table('tbl_menu')->insert($data);

			}

		}

		if ( $request->subs ) {

			foreach ($request->subs as $main) {
				
				$data = [
							'slugs' => $main,
							'category_type' => 'sub'
						];

				DB::table('tbl_menu')->insert($data);

			}
			
		}

		return redirect()->back();

	}

	public function view_user_posts($uid, $cid) {

		$posts = Posts::where('user_id', $uid)
							->where('category_id', $cid)
							->paginate(25);

		return view('user.single')->with('posts',$posts)
								  ->with('cat', Category::find($cid))
								  ->with('user', User::find($uid));

	}

}
