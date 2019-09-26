<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineTest extends Model
{
    protected $table = 'online_test';
    public $primaryKey = 'id';
    public $timestamps = true;
}
