<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Category;
use App\Report;

class Posts extends Model
{
   	protected $table = 'posts';
    public $primaryKey = 'id';
    public $timestamps = true;
    
    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function report()
    {
        return $this->hasMany('App\Report');
    }
}
