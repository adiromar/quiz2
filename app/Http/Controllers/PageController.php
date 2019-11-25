<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Course;
use App\Video;
use App\Payment;

class PageController extends Controller
{
    
	public function topics() 
	{

		$topics = Topic::orderBy('id', 'DESC')->get();

		return view('books.topics')->with('topics', $topics);

	}

	public function topic_view($slug) 
	{

		$course = Topic::where('slug', $slug)->first();

		if ( $course ) {
			
			$courses = $course->courses;

			return view('books.listcourses')->with('courses', $courses)
											->with('topic', $course->title);

		}else{

			request()->session->flash('success', 'No courses for this Topic.');

			return redirect()->back();
		
		}
		

	}

	public function course_view($slug)
	{

		$course = Course::where('slug', $slug)->first();

		return view('books.viewcourse')->with('course', $course);

	}

	public function videos(){

		$videos = Video::orderBy('id', 'DESC')->get();

		return view('books.classroom')->with('videos', $videos);

	}

	public function video_show(Video $video){

		return view('books.showvideo')->with('video', $video->first());		

	}

	public function create_payment(){

		return view('payment');

	}

	public function store_payment(Request $request)
	{

		$fileurl = '';
		if ( $request->file( 'receipt' ) ) {
			$file = $request->receipt;

			$extension = $file->extension();

			$filename = str_slug( $request->fullname, '-' ) . "-" . time() . "." . $extension;

			$destination = "uploads/payments";

			$fileurl = $destination . "/" . $filename;

			$file->move( $destination, $filename );
		}

		$pay = new Payment;

		$pay->fullname = $request->fullname;
		$pay->email = $request->email;
		$pay->mobile_no = $request->mobile_no;
		$pay->receipt = $fileurl;

		$pay->save();

		$request->session()->flash('success', 'Succesfully submitted! We will verify soon. Thanks.');

		return redirect('/');

	}

}
