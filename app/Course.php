<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = "book_courses";

    public function topics() 
    {
    	return $this->belongsToMany('App\Topic', 'course_topic');
    }
}
