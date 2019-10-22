<?php

namespace App\Imports;

use App\Posts;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class PostsImport implements ToModel, WithHeadingRow
{

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        if ( $row['category_id'] != null || $row['category_id'] != '' ) {

          $post = new Posts;

          $post->category_id = $row['category_id'];
          $post->post_name = $row['post_name'];
          $post->option_a = $row['option_a'];
          $post->option_b = $row['option_b'];
          $post->option_c = $row['option_c'];
          $post->option_d = $row['option_d'];
          $post->correct_option = $row['correct_option'];
          $post->explanation = $row['explanation'];
          $post->user_id = Auth::id();

          $post->save();

          return $post;

        }



    }
}
