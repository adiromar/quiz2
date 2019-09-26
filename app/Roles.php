<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Roles extends Model
{
    protected $table = 'role_user';
    public $primaryKey = 'id';
    public $timestamps = true;

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
