<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MainCategory;
use App\Category;
use App\Posts;
use App\Payment;
use App\Paragraph;
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
        $this->middleware('auth', ['except' => ['index','quiz_sets','set_view']]);
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

        $sets = DB::table('sets')->orderBy('order')->get();

        session()->forget('dataIds');
        session()->forget('datalist');

        return view('index')->with('main', $main)
                            ->with('category1', $category1)
                            ->with('sets', $sets);
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
        $sets = DB::table('sets')->orderBy('order')->get();

        return view('listall')->with('main', $main)
                              ->with('category1', $category1)
                              ->with('sets', $sets);
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

          if ( $val->no_of_question ) {
            $data[] = DB::table('posts')->where('category_id', $val->category_id)
                        ->inRandomOrder()->get()->take( $val->no_of_question )->toArray();
          }

        }
        // dd( $data );
        
        //Check if session has data ids
        if ( session()->get('dataIds') == null ) {

            $data1 = $dataIds = [];
            foreach ($data as $dat) {
                if ( !empty($dat) && is_array( $dat ) ) {

                    foreach ($dat as $dkey) {

                        if ( $dkey->category_id != 1000 ) {
                            $data1[] = $dkey;
                            $dataIds[] = $dkey->id;
                        }

                    }

                }
            }

            //Add data ids to session
            session(['dataIds' => json_encode( $dataIds ) ]);

        }else{

            $ids = session()->get('dataIds');
            $data1 = [];
            foreach (json_decode($ids) as $k) {
                if ( $k != 1000 ) {
                    $data1[] = DB::table('posts')->where('id', $k)->first();
                }
                
            }

        }

        if ( $page == 1 ) {
            $start = 1;
            $stop = 5;
        }elseif( $page > 1 ){
            $start = $page + 4 * ( $page - 1 );
            $stop = $page * 5;
        }

        if ( $start == 1 ): 
            
            $comprehensive = DB::table('question_sets')->where('question_name', $ques->setname)->where('category_id', '1000')->first();

            if ( $comprehensive ) {
                
                $paragraph = Paragraph::inRandomOrder()->get()->take( $comprehensive->no_of_question );

            }else{
                $paragraph = NULL;
            }

        else:
            $paragraph = NULL;
        endif;

        return view('posts.showsets')->with('data', $data1)
                                     ->with('set', $ques)
                                     ->with('page', $page)
                                     ->with('start', $start)
                                     ->with('stop', $stop)
                                     ->with('paragraph', $paragraph);


    }

    public function extraFunc(){
        //Store dataids using setid
        //1. Check if column is not null
        $col = DB::table('sets')->first();
        if ( $col->temp_ids == '' || $col->temp_ids == NULL ) {

            //2. Update
            DB::table('sets')->where('id', $ques->id)->update(['temp_ids' => json_encode( $dataIds ) ]);
        }else{
            $data1 = DB::table('posts')->wherein('id', json_decode($col->temp_ids) )->skip(0)->take(5)->get();
        }
    }

    public function payments_report(){

        $payments = Payment::orderBy('id', 'DESC')->get();

        return view('auth.payments')->with('payments', $payments);

    }

}
