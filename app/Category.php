<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\MainCategory;
use App\QuestionSets;

class Category extends Model
{
    protected $table = 'category';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function posts() {
        return $this->hasMany('App\Posts', 'category_id');
    }

    public function maincategory(){
    	return $this->belongsTo('App\MainCategory');
    }

    public function questionssets(){
        return $this->belongsTo('App\QuestionSets');
    }
    
    
}
