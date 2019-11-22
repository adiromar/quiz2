<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;
use Auth;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $topics = Topic::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();

        return view('topics.index')->with('topics', $topics);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validateWith([
            'topic_title' => 'required'
        ]);

        $topic = new Topic;

        $topic->title = $request->topic_title;
        $topic->slug = str_slug( $request->topic_title , '-');
        $topic->user_id = Auth::id();

        $topic->save();

        $request->session()->flash('success', 'Succesfully added a topic.');

        return redirect()->route('topics.index');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topic  $topic
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $topic = Topic::find( $id );

        $topic->delete();

        request()->session('success', 'Succesfully removed.');

        return redirect()->back();

    }
}
