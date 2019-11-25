<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paragraph extends Model
{
    
	protected $fillable = [
        'title', 'paragraph', 'user_id'
    ];

    public function posts()
    {
        return $this->belongsToMany('App\Posts');
    }
}
