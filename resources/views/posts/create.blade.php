@extends('layouts.admin')

@section('content')

<div class="container">
	{{-- <div class="row mt-4"> --}}
		<div class="col-md-12 mt-4 mb-5">

		<div class="card crd_border">
			<form action="{{ action('PostsController@store') }}" method="post" enctype="multipart/form-data">
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

				<div class="card-header"><h4>Create Posts</h4></div>
				<div class="row ml-2">
				<div class="col-md-4 col-lg-4 col-xs-4 mt-4">
					<label><b>Category: </b></label>
						<select class="form-control" name="category_name" id="cat_name">
							<option value="">Select</option>
							@if(count($category) > 0)
								@foreach($category as $cat)
									<option value="{{  $cat->category_name }}" data-id="{{ $cat->id}}">{{ $cat->category_name }}</option>

								@endforeach
							@endif
						</select>
				</div>
				
				<div class="col-md-4 col-lg-4 col-xs-4 mt-4">
					<label for="Question Level"><b>Level</b></label>
					<input type="text" name="level" class="form-control" title="Question Level ( Default is 1)" placeholder="Default: 1">	
				</div>

				<select style="display: none;" name="category_id"><option id="append_id"></option></select>
				</div>


				<div class="col-md-12 col-sm-4 mt-4 pb-4">
					<label><b>Question: </b></label>
					<br>
					
					<textarea id="editor1" name="question" rows="4" cols="100" placeholder="Enter Your Question"></textarea>

					<br>

					<label for="">Question Image (optional)</label>
					<input type="file" name="questionimage" >
				</div>
				
				
				<div class="row mt-4 pl-4 pr-4">
				
				<div class="col-md-6 wrapper">

					<label><b>Option A:</b></label>
					<br>
					<input type="radio" name="radioa" data-inp="option_a" value="0" class="radiobtn" checked> Normal
					<input type="radio" name="radioa" data-inp="option_a" value="1" class="radiobtn"> Image
					<br>
					<div class="input_wrap">
						<input type="text" name="option_a" class="form-control" placeholder="Enter Option">	
					</div>
					
				</div>

				<div class="col-md-6 wrapper">
					<label><b>Option B: </b></label>
					<br>
					<input type="radio" name="radiob" data-inp="option_b" value="0" class="radiobtn" checked> Normal
					<input type="radio" name="radiob" data-inp="option_b" value="1" class="radiobtn"> Image
					<br>
					<div class="input_wrap">
						<input type="text" name="option_b" class="form-control" placeholder="Enter Option">
					</div>
				</div>
				</div>

				<div class="row mt-4 pl-4 pr-4">
					<div class="col-md-6 wrapper">
					<label><b>Option C: </b></label>
					<br>
					<input type="radio" name="radioc" data-inp="option_c" value="0" class="radiobtn" checked> Normal
					<input type="radio" name="radioc" data-inp="option_c" value="1" class="radiobtn"> Image
					<br>
					<div class="input_wrap">
						<input type="text" name="option_c" class="form-control" placeholder="Enter Option">
					</div>
				</div>

				<div class="col-md-6 wrapper">
					<label><b>Option D: </b></label>
					<br>
					<input type="radio" name="radiod" data-inp="option_d" value="0" class="radiobtn" checked> Normal
					<input type="radio" name="radiod" data-inp="option_d" value="1" class="radiobtn"> Image
					<br>
					<div class="input_wrap">
						<input type="text" name="option_d" class="form-control" placeholder="Enter Option">
					</div>
				</div>
				</div>
				
				<hr/>

				<div class="row mt-4 mb-4 pl-4 pr-4">
				<div class="col-md-6">
					<label><b>Correct Option: </b></label>
					<select class="form-control" name="correct_option">
						<option value="a">Option A</option>
						<option value="b">Option B</option>
						<option value="c">Option C</option>
						<option value="d">Option D</option>
						{{-- <option value="all">All of the above</option> --}}
						{{-- <option value="none">None of the above</option> --}}
					</select>
				</div>

				<div class="col-md-12 mt-4">
					<label><b>Explanation: </b></label><br>
					<textarea name="explanation" rows="4" cols="120" placeholder="Explanation"></textarea>
				</div>
				</div>
				
				
				<input type="submit" name="go" value="Submit" class="btm btn-primary ml-4 mb-4">
			</form>

		</div>

		</div>
	{{-- </div> --}}
</div>

 <script src="http://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready( function(){

  $('#cat_name').on('change', function (e){
    e.preventDefault(); // Stop posting to the server
    // var selectedOptions = $('select[data="id"] option:selected'); 
    var selectedOptions = $(this).find(':selected').attr('data-id')
    // alert(selectedOptions);
    $('#append_id').text(selectedOptions);
    
    // $('form').submit();
  });

});
</script>

@endsection