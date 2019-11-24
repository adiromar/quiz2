<?php

namespace App\Http\Controllers;

use App\Course;
use App\Topic;
use App\Video;

use Illuminate\Http\Request;

use Auth;
use Input;

class CourseController extends Controller
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
        
        $courses = Course::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();

        return view('courses.index')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $topics = Topic::orderBy('title', 'ASC')->get();

        return view('courses.create')->with('topics', $topics);
    
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
                                'title' => 'required|min:8',
                                'topic' => 'required',
                                'content' => 'required',
                                'featured' => 'image'
                            ]);

        // Handle Image Upload
        $fileurl = "";
        $featured = $request->file('featured');
        if ( $featured ) {

            $extension = $featured->extension();
            
            $filename =  str_slug( $request->title, '-' ) . "-" . time() . "." . $extension;

            $destination = "uploads/courses";

            $fileurl = $destination . "/" . $filename;

            $featured->move( $destination , $filename );
        }
        
        $course = new Course;

        $course->title = $request->title;
        $course->slug = str_slug( $request->title, '-' );
        $course->content = $request->content;
        $course->featured = $fileurl;
        $course->user_id = Auth::id();

        $course->save();

        if ( $course ) {
            
            $course->topics()->sync( array( $request->topic ) );

        }

        $request->session()->flash('success', 'Succesfully added new course.');

        return redirect()->route('courses.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        
        $topics = Topic::orderBy('title', 'ASC')->get();
        return view('courses.edit')->with('course', $course)
                                    ->with('topics', $topics);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {

        $this->validateWith([
                                'title' => 'required|min:8',
                                'topic' => 'required',
                                'content' => 'required',
                                'featured' => 'image'
                            ]);

        // Handle Image Upload
        $fileurl = "";
        $featured = $request->file('featured');
        if ( $featured ) {

            $extension = $featured->extension();
            
            $filename =  str_slug( $request->title, '-' ) . "-" . time() . "." . $extension;

            $destination = "uploads/courses";

            $fileurl = $destination . "/" . $filename;

            $featured->move( $destination , $filename );
        }

        $course->title = $request->title;
        $course->slug = str_slug( $request->title, '-' );
        $course->content = $request->content;
        if ( $featured ) {
            $course->featured = $fileurl;
        }
        $course->user_id = Auth::id();

        $course->save();

        if ( $course ) {
            
            $course->topics()->sync( array( $request->topic ) );

        }

        $request->session()->flash('success', 'Succesfully update the course.');

        return redirect()->route('courses.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $course = Course::find($id);

        $course->delete();

        request()->session()->flash('success', 'Succesfully removed.');

        return redirect()->back();

    }

    /**
     *  Video Url
     */
    public function video_create() 
    {

        $videos = Video::where('user_id', Auth::id())->orderBy('id', 'DESC')->get();

        return view('courses.video')->with('videos', $videos);

    }

    public function video_store(Request $request)
    {


        $this->validateWith([
            'title' => 'required|min:10',
            'videourl' => 'url|required',
            'info' => 'required'
        ]);
        
        $video = new Video;

        $video->user_id = Auth::id();
        $video->title = $request->title;
        $video->slug = str_slug( $request->title, '-' );
        $video->url = $request->videourl;
        $video->description = $request->info;

        $video->save();

        request()->session()->flash('success', 'Video information added.');

        return redirect()->route('video.create');


    }
}
