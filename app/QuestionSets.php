<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionSets extends Model
{

	protected $table = 'question_sets';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function category() {
        return $this->hasMany('App\Category');
    }
}
