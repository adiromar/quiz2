<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Query\Builder;
use App\Category;
use App\MainCategory;
use App\Posts;
use App\User;
use App\Ranking;
use DB;
use App\QuestionSets;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',
          ['except' => ['show', 'cat', 'online_test', 'validate_test','test','online_quiz','rankings']
        ]);
    }

    public function index()
    {
        $title = 'Category Page';

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
    public function cat(Request $request, $main, $slug, $id, $page)
    {
        $categoryy = Category::find($id);

        if ( Auth::id() ) {
            $id = Auth::id();
            $lev = DB::table('users')->where('id', $id)->pluck('level')->first();

            $postss = DB::table('posts')->where([
                ['level', '<=', $lev],
                ['category_id', '=', $categoryy->id],
            ])->inRandomOrder()->get();
        }else{
            $postss = DB::table('posts')->where([
                ['category_id', '=', $categoryy->id],
            ])->inRandomOrder()->get();
        }



        if ( $request->session()->get('datalist') == null ) {

            $catDataIds = [];
            foreach ($postss as $p) {
                $catDataIds[] = $p->id;
            }

            session(['datalist' => json_encode($catDataIds) ]);

        }else{

            $ids = session()->get('datalist');
            $postss = [];
            foreach (json_decode($ids) as $k) {


                $postss[] = DB::table('posts')->where('id', $k)->first();

            }

        }

        if ( $page == 1 ) {
            $start = 1;
            $stop = 5;
        }elseif( $page > 1 ){
            $start = $page + 4 * ( $page - 1 );
            $stop = $page * 5;
        }

        $pg = 0;
        return view('category.show')->with('postss', $postss)
                                    ->with('categoryy', $categoryy)
                                    ->with('main', $main)
                                    ->with('slug', $slug)
                                    ->with('page', $page)
                                    ->with('start', $start)
                                    ->with('stop', $stop)
                                    ->with('pg', $pg);
    }

    public function online_test($slug, $id)
    {
        $categoryy = Category::find($id);
        $postss = $categoryy->posts()->inRandomOrder()->take(20)->get();

        return view('category.online_test')->with('postss', $postss)->with('categoryy', $categoryy);
    }

    public function online_test_set($set, $id)
    {

      $ques = DB::table('sets')->where('id', $id)->first();

      $all = DB::table('question_sets')->select('category_id','no_of_question')->where('question_name', $ques->setname)->get();

      $userlevel = Auth::user()->level;
      // echo "<pre>";
      $data = [];
      foreach ( $all as $val ) {

          if ( $val->no_of_question ) {
            $data[] = DB::table('posts')->where('category_id', $val->category_id)
                                        ->where('level', '<=', $userlevel)
                                        ->inRandomOrder()
                                        ->get()
                                        ->take( $val->no_of_question )
                                        ->toArray();
          }

      }

      $data1 = $dataIds = [];

      foreach ($data as $dat) {


              if ( !empty($dat) ) {

                  foreach ($dat as $dkey) {

                      $data1[] = $dkey;
                      $dataIds[] = $dkey->id;

                  }

              }

      }

      return view('category.test')->with('postss', $data1)->with('set', $ques);


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

        DB::table('test_results')->insert([
        ['category_id' => '67'],
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

    public function set_index(){
      $category = Category::orderBy('created_at', 'desc')->get();
      $sets = DB::table('sets')->get();
      return view('category.sets')->with('category', $category)
                                      ->with('sets', $sets);
    }

    public function create_set()
    {
        $title = 'Create Category Set';
        $category = Category::orderBy('created_at', 'desc')->get();
        $sets = DB::table('sets')->get();
        return view('category.create_set')->with('category', $category)
                                        ->with('sets', $sets);
    }

    public function edit_questionsets( $id ){

      $set = DB::table('sets')->find($id);
      $setquestions = DB::table('question_sets')
                          ->where('question_name', $set->setname)
                          ->get();

      $category = Category::orderBy('created_at', 'desc')->get();
      $sets = DB::table('sets')->get();

      return view( 'category.edit_set' )->with('set', $set)
                                        ->with('setquestions', $setquestions)
                                        ->with('category', $category);

    }

    public function store_questionsets(Request $request){
        $this->validate($request, [
            'qst_set_name' => 'required'
        ]);

        $question_name = $request->input('qst_set_name');

        //Insert question name to new table
        DB::table('sets')->insert([
                'setname' => $question_name,
                'slug' => $this->make_slug( $question_name )
        ]);

        $category_id = $request->input('category_id');
        $no_of_question = $request->input('no_of_question');
        $cc = count($no_of_question);
        $count = 0;
        foreach ($request->category_id as $value) {
            $data[] = [
                'question_name' => $question_name,
                'category_id' => $value,
                'no_of_question' => $no_of_question[$count],
                ];
            $count++;
        }
        DB::table('question_sets')->insert($data);

        return redirect()->back()->with('success', 'Question set Created');
    }

    function make_slug($string) {
        return preg_replace('/\s+/u', '-', trim($string));
    }

    public function update_questionsets(Request $request, $id){

      //Check previous setname exists or not
      if ( $request->mainsetname != $request->qst_set_name ) {

        $prev = DB::table('sets')->where('setname', $request->qst_set_name)->first();

        if ( $prev ) {
          return redirect()->back()->with('error', 'Duplicate!! Question Set Name already exists');
        }

      }

      $category_id = $request->input('category_id');
      $no_of_question = $request->input('no_of_question');
      $cc = count($no_of_question);

      DB::table('sets')->where('id', $id)->update([
          'setname' => $request->qst_set_name,
          'slug' => $this->make_slug( $request->qst_set_name ),
      ]);

      $count = 0;

      foreach ($category_id as $cid) {

        $query = DB::table('question_sets')->where('question_name', $request->mainsetname)
                                  ->where('category_id', $cid);
        $check = $query->first();

        if ( $check ) {

          $update = $query->update([
            'question_name' => $request->qst_set_name,
            'no_of_question' => $no_of_question[$count]
          ]);

        }else{

          DB::table('question_sets')->insert([
            'question_name' => $request->qst_set_name,
            'category_id' => $cid,
            'no_of_question' => $no_of_question[$count],
          ]);

        }

        $count++;
      }

      return redirect()->back()->with('success', 'Question set Updated');
    }

    public function change_order(Request $request){


        $orders = $request->order;
        $i = 0;
        foreach ($request->setids as $setid) {

            $o = $orders[$i];

            //Update row using set id
            DB::table('sets')->where('id', $setid)
                            ->update([
                                'order' => $o
                            ]);

        $i++;
        }

        return redirect()->back()->with('success', 'Order Changed');

    }

    public function destroy_questionsets($id){

      $set = DB::table('sets')->find($id);

      $setname = $set->setname;

      DB::table('question_sets')->where('question_name', $setname)->delete();

      DB::table('sets')->where('id', $id)->delete();

      return redirect()->back()->with('success', 'Sucessfully removed set.');


    }

    public function update_user_level(Request $request)
    {

        $user = User::find($request->userid);

        $userlevel = $user->level;

        $user->level = $userlevel + 1;

        $user->save();

        return response( "Level Increased." );
    }

    public function update_user_ranking(Request $request)
    {

      $timetaken = $request->timeTaken;

      $rank = new Ranking;

      $rank->user_id = Auth::id();
      $rank->totalquestions = $request->intTotalQuestions;
      $rank->correctanswers = $request->intCorrectAnswerCount;
      $rank->timetaken = $timetaken;

      $rank->save();

      return response('User stat updated');

    }

    public function rankings()
    {

      $points = DB::table("ranking")->get()->toArray();
      $users = User::all();

      $data = [];
      foreach ($users as $key) {
        $userid = $key->id;
        $rol = DB::table('role_user')->where('user_id', $userid)->first();
        if ( $rol ) {
          $role = DB::table('roles')->where('id', $rol->role_id)->first();
          $role = $role->role;
        }else{
          $role = 'User';
        }

        if ( $role == 'User' ) {
          $query = DB::table('ranking')->where('user_id', $userid);

          $total = $query->sum('totalquestions');
          $correct = $query->sum('correctanswers');
          $time = $query->sum('timetaken');

          $data[ $userid ]['name'] = $key->name;
          $data[ $userid ]['total'] = $total;
          $data[ $userid ]['correct'] = $correct;
          $data[ $userid ]['timetaken'] = $this->seconds2human($time);
          $data[ $userid ]['role'] = $role;
          $data[ $userid ]['ratio'] = $this->calc_ratio( $correct, $this->seconds2human($time) );
        }

      }

      return view('user.rankings')->with('data', $data);

    }

    function seconds2human($ss) {

      $s = $ss%60;
      $m = floor(($ss%3600)/60);
      // $h = floor(($ss%86400)/3600);
      // $d = floor(($ss%2592000)/86400);
      // $M = floor($ss/2592000);
      return $m . "." . $s;

    }

    function calc_ratio($correct, $time){

      if ( $time > 0 && $correct > 0 ) {
        $calc = $time / $correct * 100;
        return $calc;
      }else{
        return 0;
      }



    }

}
