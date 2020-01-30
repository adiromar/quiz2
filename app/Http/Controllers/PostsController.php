<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Posts;
use App\Category;
use App\User;
use App\Report;
use App\Paragraph;
use App\ComprehensiveCategories;
use App\MainCategory;
use DB;
use Session;

class PostsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth', [ 'except' => ['show', 'report_post'] ]);
    }

    public function index()
    {
        $title = 'Posts/Questions';
        $userId = Auth::id();
        $posts = Posts::where('user_id', $userId)->orderBy('id', 'desc')->paginate(25);
        return view('posts.index')->with('posts', $posts)->with('title', $title);
    }

    public function create()
    {
        $title = 'Create a Question';
    	$category = Category::orderBy('created_at', 'desc')->get();
        return view('posts.create')->with('category', $category)->with('title', $title);
    }

    public function show()
    {
        $title = 'Question Feedback';
        $report = Report::orderBy('created_at', 'desc')->paginate(25);
        return view('posts.view_report')->with('report', $report)->with('title', $title);
    }

    public function edit($id)
    {
        $title = 'Edit Question';
        $category = Category::orderBy('created_at', 'desc')->get();
        $post = Posts::find($id);

        if (auth()->user()->id !== $post->user_id){
            return redirect('posts/index')->with('error', 'Unauthorized Page');
        }else{
            return view('posts.edit')->with('post', $post)->with('category', $category)->with('title', $title);
        }

    }

    public function comprehensive_categories()
    {

        $categories = ComprehensiveCategories::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();
        
        return view('posts.comprehensive_categories')->with('categories', $categories);

    }

    public function create_comprehensive_questions()
    {
        
        $cats = ComprehensiveCategories::orderBy('title')->get();

        if ( count($cats) == 0 ) {
            return redirect()->back();
        }

        return view('posts.create_comprehensive')->with('cats', $cats);
    }

    public function comprehensive_question()
    {

        $all = Paragraph::where('user_id', Auth::id() )->orderBy('id', 'DESC')->get();
        
        return view('posts.comprehensive')->with('all', $all);

    }

    public function store(Request $request){
    	$this->validate($request, [
            'question' => 'required',
            'category_name' => 'required',
            'questionimage' => 'image'
        ]);

        // create post
        $post = new Posts;
        $userId = Auth::id();
        $post->post_name = $request->input('question');
        if ( $request->level ) {
            $post->level = $request->level;
        }else{
            $post->level = 1;
        }


        //1. Question image (featured)
        if ( $request->hasFile('questionimage') ) {
            $filename = "";
            $file = $request->questionimage;
            $filename = "featured_" . time() . "." .$file->getClientOriginalExtension();
            $file->move('uploads/images', $filename);
            $post->featured = 'uploads/images/' . $filename;
        }

        $post->category_name = $request->input('category_name');
        $post->category_id = $request->input('category_id');

        //Options
        if ( $request->hasFile('option_a') ) {
            $filename = "";
            $file = $request->option_a;
            $filename = "option_a" . time() . "." .$file->getClientOriginalExtension();
            $file->move('uploads/answers', $filename);
            $post->option_a = 'uploads/answers/' . $filename;

        }else{
            $post->option_a = $request->input('option_a');
        }

        if ( $request->hasFile('option_b') ) {
            $filename = "";
            $file = $request->option_b;
            $filename = "option_b" . time() . "." .$file->getClientOriginalExtension();
            $file->move('uploads/answers', $filename);
            $post->option_b = 'uploads/answers/' . $filename;

        }else{
            $post->option_b = $request->input('option_b');
        }

        if ( $request->hasFile('option_c') ) {
            $filename = "";
            $file = $request->option_c;
            $filename = "option_c" . time() . "." .$file->getClientOriginalExtension();
            $file->move('uploads/answers', $filename);
            $post->option_c = 'uploads/answers/' . $filename;

        }else{
            $post->option_c = $request->input('option_c');
        }

        if ( $request->hasFile('option_d') ) {
            $filename = "";
            $file = $request->option_d;
            $filename = "option_d" . time() . "." .$file->getClientOriginalExtension();
            $file->move('uploads/answers', $filename);
            $post->option_d = 'uploads/answers/' . $filename;

        }else{
            $post->option_d = $request->input('option_d');
        }

        $post->correct_option = $request->input('correct_option');
        $post->explanation = $request->input('explanation');
        $post->user_id = $userId;
        $post->save();

        return redirect('posts/create')->with('success', 'Post Created Successfully');
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'question' => 'required',
            'category_name' => 'required'
        ]);

        $new_post = Posts::find($id);

        if ( $request->hasFile('featured') ) {
            $filename = "";
            $file = $request->featured;
            $filename = "featured_" . time() . "." .$file->getClientOriginalExtension();
            $file->move('uploads/images', $filename);
            $new_post->featured = 'uploads/images/' . $filename;
        }

        $new_post->post_name = $request->input('question');
        $new_post->category_name = $request->input('category_name');
        $new_post->category_id = $request->input('category_id');

        if ( $request->hasFile('option_a') ) {
            $filename = "";
            $file = $request->option_a;
            $filename = "option_a" . time() . "." .$file->getClientOriginalExtension();
            $file->move('uploads/answers', $filename);
            $new_post->option_a = 'uploads/answers/' . $filename;

        }else{
            if ( $request->option_a ) {
                $new_post->option_a = $request->input('option_a');
            }

        }

        if ( $request->hasFile('option_b') ) {
            $filename = "";
            $file = $request->option_b;
            $filename = "option_b" . time() . "." .$file->getClientOriginalExtension();
            $file->move('uploads/answers', $filename);
            $post->option_b = 'uploads/answers/' . $filename;

        }else{
            if ( $request->option_b ) {
                $new_post->option_b = $request->input('option_b');
            }
        }

        if ( $request->hasFile('option_c') ) {
            $filename = "";
            $file = $request->option_c;
            $filename = "option_c" . time() . "." .$file->getClientOriginalExtension();
            $file->move('uploads/answers', $filename);
            $new_post->option_c = 'uploads/answers/' . $filename;

        }else{
            if ( $request->option_c ) {
                $new_post->option_c = $request->input('option_c');
            }
        }

        if ( $request->hasFile('option_d') ) {
            $filename = "";
            $file = $request->option_d;
            $filename = "option_d" . time() . "." .$file->getClientOriginalExtension();
            $file->move('uploads/answers', $filename);
            $new_post->option_d = 'uploads/answers/' . $filename;

        }else{
            if ( $request->option_d ) {
                $new_post->option_d = $request->input('option_d');
            }
        }

        $new_post->correct_option = $request->input('correct_option');
        $new_post->level = $request->level;
        $new_post->explanation = $request->input('explanation');
        $new_post->save();

        return redirect('posts/index')->with('success', 'Post Updated Successfully');
    }

    public function report_post(Request $request, $id){

        $report_username = $request->input('report_username');
        $report_email = $request->input('report_email');
        $message = $request->input('message');
        $post_id = $request->input('post_id');
        $post_name = $request->input('post_name');
        $cat_name = $request->input('cat_name');

        $crep = new Report;
        $crep->report_username = $report_username;
        $crep->report_email = $report_email;
        $crep->message = $message;
        $crep->post_id = $post_id;
        $crep->post_name = $post_name;
        $crep->cat_name = $cat_name;
        $crep->save();
        return redirect()->back()->with('success', 'Reported message succesfully.');
    }

    public function score(){
        print_r($name);
        echo "test";die;
    }

    public function destroy($id)
    {
        $post = Posts::find($id);

        if (auth()->user()->id !== $post->user_id){
            return redirect('posts/index')->with('error', 'Unauthorized Page');
        }
        $post->delete();
        return redirect('posts/index')->with('success', 'Post Removed.');
    }

    public function stats() {


        $users = User::all();

        $main = MainCategory::all();

        $cats = Category::all();

        return view('user.stats')->with('users', $users)
                                ->with('main', $main)
                                ->with('cats', $cats);

    }

    public function comprehensive_store(Request $request) {

        $this->validateWith([

                'title' => 'required',
                'paragraph' => 'required',
                'question' => 'required',
                'category' => 'required',

        ]);


        $questions = $request->question;
        $options_a = $request->option_a;
        $options_b = $request->option_b;
        $options_c = $request->option_c;
        $options_d = $request->option_d;
        $correct_options = $request->correct_option;
        $explanations = $request->explanation;

        $title = $request->title;
        
        if ( $request->level ) {
            $level = $request->level;
        }else{
            $level = 1;
        }
        
        $paragraph = $request->paragraph;

        $firstinsert = [
            'comprehensive_categories_id' => $request->category,
            'title' => $title,
            'paragraph' => $paragraph,
            'user_id' => Auth::id(),
            'level' => $level
        ];

        $insert1 = Paragraph::create( $firstinsert );

        $i = 0;$data = [];
        foreach ($questions as $ques) {
          
            $data[$i]['category_id'] = 1000;
            $data[$i]['post_name'] = $ques;
            $data[$i]['category_name'] = 'Comprehensive';
            $data[$i]['option_a'] = $options_a[$i];
            $data[$i]['option_b'] = $options_b[$i];
            $data[$i]['option_c'] = $options_c[$i];
            $data[$i]['option_d'] = $options_d[$i];
            $data[$i]['correct_option'] = $correct_options[$i];
            $data[$i]['explanation'] = $explanations[$i];
            $data[$i]['level'] = $level;
            $data[$i]['user_id'] = Auth::id();

            $i++;
        }

        foreach ($data as $d) {
            
            $post = Posts::create( $d );

            $insert1->posts()->attach($post->id);

        }


        return redirect()->route('postindex')->with('success', 'Added Comprehensive Question');

    }

    public function comprehensive_category_store(Request $request)
    {

        $cat = new ComprehensiveCategories;

        $cat->title = $request->main_category_name;
        $cat->slug = str_slug($request->main_category_name, '-');
        $cat->user_id = Auth::id();

        $cat->save();

        $request->session()->flash('success', 'Successfully added category.');

        return redirect()->back();

    }

    public function paragraph_delete($id){


        $paragraph = Paragraph::find( $id );

        $paragraph->posts()->detach();

        $paragraph->delete();

        request()->session()->flash('success', 'Successfully deleted paragraph.');

        return redirect()->back();

    }

}
