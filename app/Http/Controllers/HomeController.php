<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MainCategory;
use App\Category;
use App\Posts;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','list_all','quiz_sets','set_view']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $main = MainCategory::get();
        $category1 = MainCategory::with('category')->get();
        
        // $category = Category::orderBy('created_at', 'desc')->paginate(10);
        return view('index')->with('main', $main)->with('category1', $category1);
    }

    public function dash()
    {   
        $title = 'Dashboard Page';
        $mcat_count = MainCategory::get()->count();
        $cat_count = Category::get()->count();
        $pst_count = Posts::get()->count();
        return view('dashboard')->with('title', $title)->with('cat_count', $cat_count)->with('pst_count', $pst_count)->with('mcat_count', $mcat_count);
    }

    public function list_all()
    {   
        $main = MainCategory::get();
        $category1 = MainCategory::with('category')->get();
        return view('listall')->with('main', $main)->with('category1', $category1);
    }

    public function quiz_sets(){

        $sets = DB::table('sets')->orderBy('order')->get();

        return view('posts.sets')->with('sets', $sets);

    }

    public function set_view($set, $page){


        $ques = DB::table('sets')->where('slug', $set)->first();


        $all = DB::table('question_sets')->select('category_id','no_of_question')->where('question_name', $ques->setname)->get();

        $data = [];
        foreach ( $all as $val ) {
            
            $data[] = DB::table('posts')->where('category_id', $val->category_id)
                        ->inRandomOrder()->get()->take( $val->no_of_question )->toArray();

        }

        $data1 = [];
        foreach ($data as $dat) {
            if ( !empty($dat) ) {
                
                foreach ($dat as $dkey) {
                    
                    $data1[] = $dkey;

                }

            }
        }

        return view('posts.showsets')->with('data', $data1)
                                     ->with('set', $ques)
                                     ->with('page', $page)
                                     ->with('random', rand(0,10));

    }
}
