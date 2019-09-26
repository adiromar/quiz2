<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class UploadPost extends Model
{
    public static function insertData($data){

      // $value=DB::table('posts')->where('username', $data['username'])->get();
      // if($value->count() == 0){
         DB::table('posts')->insert($data);
      // }
   }

   public static function insertcat($data){

      // $value=DB::table('posts')->where('username', $data['username'])->get();
      // if($value->count() == 0){
         DB::table('category')->insert($data);
      // }
   }
}
