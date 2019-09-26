<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;
use App\Category;
use App\MainCategory;
use App\Posts;
use App\User;
use DB;
use App\QuestionSets;

class CategoryController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['show', 'cat', 'online_test', 'validate_test','test','online_quiz']]);
    }

    public function index()
    {	
        $title = 'Category Page';
    	// $category = Category::orderBy('created_at', 'desc')->get();
        $main = MainCategory::get();
    	$category = Category::orderBy('created_at', 'desc')->paginate(20);
        return view('category.index')->with('category', $category)->with('main', $main)->with('title', $title);
    }

    public function create()
    {
        $main = MainCategory::get();
        return view('category.create')->with('main', $main);
    }


    // view questions all category wise & level wise
    public function cat($main, $slug, $id)
    {   
        $categoryy = Category::find($id);
        $id = Auth::id();
        $lev = DB::table('users')->where('id', $id)->pluck('level')->first();
        // dd($lev);
        // $postss = $categoryy->posts()->inRandomOrder()->simplePaginate(5);

        $postss = DB::table('posts')->where([
            ['level', '<=', $lev],
            ['category_id', '=', $categoryy->id],
        ])->inRandomOrder()->simplePaginate(5);
        return view('category.show')->with('postss', $postss)->with('categoryy', $categoryy)->with('main', $main)->with('slug', $slug);
    }

    public function online_test($slug, $id)
    {   
        $categoryy = Category::find($id);
        $postss = $categoryy->posts()->inRandomOrder()->get();
       
        return view('category.online_test')->with('postss', $postss)->with('categoryy', $categoryy);
    }

    public function test($slug, $id)
    {   
        $categoryy = Category::find($id);
        $main = MainCategory::find($categoryy->main_category_id);
        $postss = $categoryy->posts()->inRandomOrder()->get();
       
        return view('category.test')->with('postss', $postss)->with('categoryy', $categoryy)->with('main', $main)->with('slug', $slug);
    }

    public function online_quiz($slug, $id)
    {   
        $categoryy = Category::find($id);
        $postss = $categoryy->posts()->inRandomOrder()->take(20)->get();
        
        // $items = $postss->toJson();
        foreach ($postss as $pst => $post) {
            $items[$pst] = [
                'question' => $postss[$pst]->post_name,
                'choices'  => [
                    0 => $postss[$pst]->option_a, 
                    1 => $postss[$pst]->option_b, 
                    2 => $postss[$pst]->option_c, 
                    3 => $postss[$pst]->option_d
                ], 
                'correctAnswer' => $postss[$pst]->correct_option,
            ];
        }
        
        // $items = $postss->toJson();
        return view('category.online_quiz')->with('categoryy', $categoryy)->with(compact('items', 'items'));
    }

    public function store(Request $request){
    	$this->validate($request, [
            'category_name' => 'required',
            'main_category_id' => 'required' ]);

        // create post
        $cat = new Category;
        $userId = Auth::id();
        $cat->category_name = $request->input('category_name');
        $slug = str_replace(' ', '-', $request->input('category_name'));
        $cat->slug = strtolower($slug);
        $cat->main_category_id = $request->input('main_category_id');
        $cat->featured = '1';
        $cat->user_id = $userId;
        $cat->save();

        return redirect('category/index')->with('success', 'Category Created');
    }

    public function featured_cat(Request $request, $id){

        $cat_id = $request->input('cat_id');
        $status = $request->input('status');
        $feat = $request->input('featured');

        $cat = Category::find($id);
        $cat->featured = $status;
        $cat->save();
        return redirect()->back()->with('success', 'Changed Featured Category.');
    }

    public function validate_test(Request $request){
        // echo '<pre>';
        // dd((array) $_POST);
        // $cat_id = $request->input('cat_id');
        // for ($i=1; $i < $count; $i++) { 
        //     $opt = 'option' . $i;
        //     $option = $request->input($opt);
        //     print_r($option);
        // }
        DB::table('test_results')->insert([
        ['category_id' => '67'],
        // ['email' => 'dayle@example.com', 'votes' => 0]
        ]);
        
        
        return response()->json($request);
    }

    public function destroy($id)
    {   
        $caty = Category::find($id);
        $caty->delete();
        return redirect('category/index')->with('success', 'Category Removed.');
    }

    public function new_test($slug, $id)
    {   
        $categoryy = Category::find($id);
        $postss = $categoryy->posts()->inRandomOrder()->get();
       
        return view('category.newtest')->with('postss', $postss)->with('categoryy', $categoryy);
    }

    public function list_all()
    {   
        return view('category.listall')->with('pos', $pos);
    }

    public function create_set()
    {   
        $title = 'Create Category Set';
        $category = Category::orderBy('created_at', 'desc')->get();
        // $main = MainCategory::get();
        // $category = Category::orderBy('created_at', 'desc')->paginate(20);
        // return view('category.create_set')->with('category', $category)->with('main', $main)->with('title', $title);
        return view('category.create_set')->with('category', $category);
    }

    public function store_questionsets(Request $request){
        $this->validate($request, [
            'qst_set_name' => 'required']);

        $question_name = $request->input('qst_set_name');
        $category_id = $request->input('category_id');
        $no_of_question = $request->input('no_of_question');
        $cc = count($no_of_question);

        foreach ($request as $key => $value) {
            $data[] = [
                'question_name' => $value['qst_set_name'],
                'category_id' => $value['category_id'],
                'no_of_question' => $value['no_of_question'],
                ];
        }
        DB::table('question_sets')->insert($data);
        // $data = [];
        // for ($k=0; $k < $cc; $k++) { 
        //     $data[] = array('question_name'=>$question_name, 'category_id'=>$category_id[$k,'no_of_question'=>$no_of_question[$k]
        //     );
            
            
        // }
        // QuestionSets::Insert($data);
        // create post
        // $qst = new QuestionSets;
        // $userId = Auth::id();
        // $qst->question_name = $request->input('qst_set_name');
        // $qst->category_id = $request->input('category_id');
        // $qst->no_of_question = $request->input('no_of_question');
        // $qst->save();

        return redirect('/store_question_sets')->with('success', 'Question set Created');
    }
}