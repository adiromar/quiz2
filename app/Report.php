<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'report_question';
    public $primaryKey = 'id';
    public $timestamps = true;
}
