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
    
    protected $fillable = [
        'category_id', 'post_name', 'category_name', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_option', 'explanation', 'level', 'user_id',
    ];

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

    public function paragraphs()
    {
        return $this->belongsToMany('App\Paragraph');
    }
}
