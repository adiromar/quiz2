<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComprehensiveCategories extends Model
{
    
	public function paragraphs()
	{
		return $this->hasMany('App\Paragraph');
	}

}
