<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\MainCategory;
use App\Category;

class MainCategory extends Model
{
    protected $table = 'main_category';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function category() {
        return $this->hasMany('App\Category', 'main_category_id');
    }
}
