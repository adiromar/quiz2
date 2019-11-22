<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Topic;
use App\Course;

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

}
