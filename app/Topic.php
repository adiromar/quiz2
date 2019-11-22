<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = "book_topics";

    public function courses() 
    {
    	return $this->belongsToMany('App\Course', 'course_topic');
    }
}
