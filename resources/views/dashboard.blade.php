@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row">

        <div class="col-md-12 mt-4">
            <div class="card crd_border">
                <div class="card-header"><h4>Dashboard</h4></div>

                <div class="panel-body">

                    <div class="col-md-12">
                        <h5 class="dsh_head">Main Category</h5>
                        <div class="row">

                            <div class="col-md-4">
                                <p><b>{{ $mcat_count }}</b> Main Categories created.</p>
                            </div>

                            <div class="col-md-3">
                                <a href="{{ url('maincategory/create') }}" class="btn btn-info btn-sm mt-2 ml-4">+ Create/view</a>
                            </div>
                        </div>
                        
                        <hr>
                         <h5 class="dsh_head">Category</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <p><b>{{ $cat_count }}</b> Categories created.</p>
                            </div>

                            <div class="col-md-3">
                                <a href="{{ url('category/create') }}" class="btn btn-info btn-sm mt-2 ml-4">+ Create/view</a>
                            </div>
                        </div>
                        
                        <hr>
                        <h5 class="dsh_head">Questions/posts</h5>
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <p><b>{{ $pst_count }}</b> Posts Created.</p>
                            </div>

                            <div class="col-md-3">
                                <a href="{{ url('posts/index') }}" class="btn btn-info btn-sm mt-2 ml-4">+ Create/view</a>
                            </div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>

        <div class="col-md-12 mt-4 mb-4">
            <div class="card crd_border">
                <div class="card-header"><h4>Sample Upload File Format (csv)</h4></div>
                    <div class="col-md-12 mt-4 mb-4">
                        <h6>Upload Instructions: </h6>
                        <p>- File Format Supports only .csv, .xlsx </p>
                        <p>- Create Category from category page.</p>
                        <p>- Add Category Id in excel file in category id column.</p>
                        <p>- Created Category Id should match with the category id in csv file.</p>
                        <p>- Insert Post name, four option, and one correct answer. If the correct option is 'Option A', add 'a' in the correct option column.</p>
                        <p>- First Line of excel (heading) must be fixed and cannot be changed.</p>
                        <p>- Upload Questions</p>

                        <div class="collapse mb-4" id="collapseExample">
                            <div class="card card-body">
                            <h6>Sample Example:</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>category_id</th>
                                        <th>post_name</th>
                                        <th>option_a</th>
                                        <th>option_b</th>
                                        <th>option_c</th>
                                        <th>option_d</th>
                                        <th>correct_option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>What is the capital of Brazil ?</td>
                                        <td>Rio de Janeiro</td>
                                        <td>Salvador</td>
                                        <td>Sao Paulo</td>
                                        <td>Brasilia</td>
                                        <td>d</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        <a href="#collapseExample" data-toggle="collapse" class="btn btn-warning" role="button" aria-expanded="false" aria-controls="collapseExample">Preview</a>
                        <a href="{{ asset('uploads/sample.csv') }}" class="btn btn-secondary"><i class="fa fa-download"></i> Download csv</a>
                        <a href="{{ asset('uploads/quiz_question_format.xlsx') }}" class="btn btn-info"><i class="fa fa-download"></i> Download Excel</a>
                        

                    </div>
                </div>
        </div>

        <div class="col-md-12 mt-4 mb-5">
            <div class="card crd_border">
                <div class="card-header"><h4>Upload Questions</h4></div>
                    <div class="col-md-12 mt-4 mb-4">
                        <form method='post' action='{{ action('UploadPostController@uploadFile') }}' enctype='multipart/form-data' >
                        {{ csrf_field() }}
                        <label class="col-md-12">Upload Questions (CSV): </label>
                        <input type="file" name="file" class="btn btn-light" required>
                        <input type="submit" name="submit" value="Import" class="btn btn-primary ml-2">
                        </form>
                    </div>
            </div>
        </div>

        {{-- upload excel new --}}
        <div class="col-md-12 mt-4 mb-5">
            <div class="card crd_border">
                <div class="card-header"><h4>Upload Questions</h4></div>
                    <div class="col-md-12 mt-4 mb-4">
                        <form method='post' action='{{ action('UploadPostController@uploadFile2') }}' enctype='multipart/form-data' >
                        {{ csrf_field() }}
                        <label class="col-md-12">Upload Questions (excel): </label>
                        <input type="file" name="file" class="btn btn-light" required>
                        <input type="submit" name="submit2" value="Import" class="btn btn-primary ml-2">
                        </form>
                    </div>
            </div>
        </div>

    </div>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>
@endsection
