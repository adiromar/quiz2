<?php

namespace App\Http\Controllers;
// namespace App\Exports;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UploadPost;
use App\Category;
use App\Posts;
// use Session;
use Illuminate\Support\Facades\Auth;
use Excel;
use DB;

class UploadPostController extends Controller
{

    public function uploadFilee(Request $request){

    if ($request->input('submit') != null || $request->input('submit2') != null){

      $file = $request->file('file');

      // File Details
      $filename = $file->getClientOriginalName();
      $extension = $file->getClientOriginalExtension();
      $tempPath = $file->getRealPath();
      $fileSize = $file->getSize();
      $mimeType = $file->getMimeType();

      // Valid File Extensions
      $valid_extension = array("csv","xlsx");

      // 2MB in Bytes
      $maxFileSize = 2097152;

      // Check file extension
      if(in_array(strtolower($extension),$valid_extension)){

        // Check file size
        if($fileSize <= $maxFileSize){

          // File upload location
          $location = 'uploads/questions';

          // Upload file
          // $file->move($location,$filename);

          // Import CSV to Database
          // $filepath = public_path($location."/".$filename);

          // Reading file
          $files = fopen($file,"r");

          $importData_arr = array();
          $i = 0;

          while (($filedata = fgetcsv($files, 1000, ",")) !== FALSE) {
             $num = count($filedata );

             // Skip first row (Remove below comment if you want to skip the first row)
             if($i == 0){
                $i++;
                continue;
             }
             for ($c=0; $c < $num; $c++) {
                $importData_arr[$i][] = $filedata [$c];
             }
             $i++;
          }
          fclose($files);
          $ldate = date('Y-m-d H:i:s');
          $userId = Auth::id();
          // Insert to category table
          $slug ='';

          // dd($importData_arr);die;
         foreach($importData_arr as $importData){
          $slug = str_replace(' ', '-', $importData[0]);
          $slug = strtolower($slug);

          // if (Category::where('category_name', '=', $importData[0])->exists()) {
          //   // user found
          //   echo "category already exists";
          // }else{
          //   $catData = array(
          //      "category_name"=>$importData[0],
          //      "slug"=>$slug,
          //      "user_id"=>$userId,
          //      "created_at"=>$ldate,
          //      "updated_at"=>$ldate
          //    );
          //   UploadPost::insertcat($catData);
          // }

            // now upload posts , check for category id exists or not
          if (Category::where('id', '=', $importData[0])->exists()){
            $catname ='';
            if (Posts::where('post_name', '=', $importData[2])->exists()) {
            // user found
            // return redirect()->action('PostsController@index')->with('warning', 'Question Already Exists.');
            }else{
              $catname = Category::where('id', '=', $importData[0])->get();
              // echo '<pre>';
              // print_r($catname);die;
            $insertData = array(
              "category_name"=>$catname[0]->category_name,
               "category_id"=>$importData[0],
               "post_name"=>$importData[1],
               "option_a"=>$importData[2],
               "option_b"=>$importData[3],
               "option_c"=>$importData[4],
               "option_d"=>$importData[5],
               "correct_option"=> strtolower($importData[6]),
               "explanation"=>$importData[7],
               "user_id"=>$userId,
               "created_at"=>$ldate,
               "updated_at"=>$ldate
             );
            // print_r($insertData);die;
            UploadPost::insertData($insertData);
            }

          }else{
            return redirect()->action('PostsController@index')->with('danger', 'category id does not exists in database');
            // echo "This category id does not exists in database";
          }

          }

          return redirect()->action('PostsController@index')->with('success', 'Upload Successful.');
          // Session::flash('message','Import Successful.');
        }else{
          return redirect()->action('PostsController@index')->with('warning', 'File too large. File must be less than 2MB.');
          // Session::flash('message','File too large. File must be less than 2MB.');
        }

      }else{
        return redirect()->action('PostsController@index')->with('danger', 'Invalid File Extension.');
         // Session::flash('message','Invalid File Extension.');
      }

    }else{
        return redirect()->action('PostsController@index')->with('warning', 'Please Upload a File.');
    }

    // Redirect to index
    return redirect()->action('PostsController@index');
  }

//  New function for uploading excel file to database

    public function uploadFile(Request $request){
        $ldate = date('Y-m-d H:i:s');
          $userId = Auth::id();

      if ($request->input('submit2') != null ){
        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path)->get();

            if($data->count()){

              $catname = '';

                foreach ($data as $key => $value) {

                  if (Category::where('id', '=', $value->category_id)->exists()){

                    if (Posts::where('post_name', '=', $value->post_name)->exists()) {
                    // user found
                      return redirect()->action('PostsController@index')->with('warning', 'Question Already Exists.');
                    }else{
                  $catname = Category::where('id', '=', $value->category_id)->get();
                  $catname = $catname[0]->category_name;
                  // dd($catname);die;
                    $arr[] = [
                    'category_name' => $catname,
                    'category_id' => $value->category_id,
                    'post_name' => $value->post_name,
                    'option_a' => $value->option_a,
                    'option_b' => $value->option_b,
                    'option_c' => $value->option_c,
                    'option_d' => $value->option_d,
                    'correct_option' => $value->correct_option,
                    'user_id' => $userId,
                    'created_at' => $ldate,
                    'updated_at'=> $ldate
                  ];
                    }
                  } // endif
                }
              if(!empty($arr)){
                    UploadPost::insertData($arr);
                    return redirect()->action('PostsController@index')->with('success', 'Upload Successful.');
                }
             }
        }
        dd('Request data does not have any files to import.');

        }
      }

      public function uploadFile2(Request $request){
        $ldate = date('Y-m-d H:i:s');
          $userId = Auth::id();

          if ($request->input('submit2') != null ){
        if($request->hasFile('file')){
          dd($request);
        }
      }

      }


// end of class
}
