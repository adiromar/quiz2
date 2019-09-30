<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\MainCategory;
use App\Category;
use Illuminate\Support\Facades\Crypt;

class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug, $id)
    {   
        // $did = Crypt::decrypt($id);
        $main = MainCategory::find($id);
        $submain = Category::where('main_category_id', $id)->get();

        session()->forget('dataIds');
        session()->forget('datalist');
        
        return view('maincategory.index')->with('main', $main)->with('submain', $submain);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $title = 'Main Category';
        $main = MainCategory::orderBy('created_at', 'desc')->get();
        return view('maincategory.create')->with('main', $main)->with('title' , $title);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $this->validate($request, [
            'main_category_name' => 'required' ]);

        // create post
        $cat = new MainCategory;
        $userId = Auth::id();
        $cat->main_category_name = $request->input('main_category_name');
        $slug = str_replace(' ', '-', $request->input('main_category_name'));
        $cat->slug = strtolower($slug);
        $cat->featured = '1';
        $cat->user_id = $userId;
        $cat->save();

        return redirect()->back()->with('success', 'Main Category Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $main = MainCategory::find($id);
        $main->delete();
        return redirect('maincategory/create')->with('success', 'Main Category Removed.');
    }

    public function featured_cat(Request $request, $id){

        $cat_id = $request->input('cat_id');
        $status = $request->input('status');
        $feat = $request->input('featured');

        $cat = MainCategory::find($id);
        $cat->featured = $status;
        $cat->save();
        return redirect()->back()->with('success', 'Changed Featured Status in Main Category.');
    }
}
