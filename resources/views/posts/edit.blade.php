@extends('layouts.admin')

@section('content')
<?php
  //dd($post);die;

?>
<div class="container">
	{{-- <div class="row mt-4"> --}}
		<div class="col-md-12 mt-4 mb-5">

		<div class="card crd_border">
			<form action="{{ route('posts.update', $post->id) }}" method="post">
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
				{{csrf_field()}}
                {{ method_field('PUT') }}
				<div class="card-header"><h4>Update Posts</h4></div>

				<div class="row ml-2">
				<div class="col-md-4 mt-4">
					<label><b>Category: </b></label>
						<select class="form-control" name="category_name" id="cat_name">
							<option value="">Select</option>
							@if(count($category) > 0)
								@foreach($category as $cat)
									<option value="{{  $cat->category_name }}" data-id="{{ $cat->id}}" {{ $cat->category_name == $post->category_name ? 'selected' : ''}}>{{ $cat->category_name }}</option>

								@endforeach
							@endif
						</select>
				</div>

				<select style="display: none;" name="category_id"><option id="append_id">{{ $post->category_id }}</option></select>
				</div>


				<div class="col-md-12 mt-4">
					<label><b>Question: </b></label><br>
					{{-- <input type="text" name="post" class="form-control"> --}}
					<textarea name="question" rows="4" cols="120" value="{{ $post->post_name }}">{{ $post->post_name }}</textarea>
				</div>

				<div class="row mt-4 pl-4 pr-4">
				<div class="col-md-6">
					<label><b>Option A: </b></label>
					<input type="text" name="option_a" class="form-control" value="{{ $post->option_a }}">
				</div>

				<div class="col-md-6">
					<label><b>Option B: </b></label>
					<input type="text" name="option_b" class="form-control" value="{{ $post->option_b }}">
				</div>
				</div>

				<div class="row mt-4 pl-4 pr-4">
					<div class="col-md-6">
					<label><b>Option C: </b></label>
					<input type="text" name="option_c" class="form-control" value="{{ $post->option_c }}">
				</div>

				<div class="col-md-6">
					<label><b>Option D: </b></label>
					<input type="text" name="option_d" class="form-control" value="{{ $post->option_d }}">
				</div>
				</div>

				<div class="row mt-4 mb-4 pl-4 pr-4">
				<div class="col-md-6">
					<label><b>Correct Option: </b></label>
					<select class="form-control" name="correct_option">
						{{-- <option>{{ $post->correct_option }}</option> --}}
						<option value="a" {{ $post->correct_option == 'a' ? 'selected' : ''}}>Option A</option>
						<option value="b" {{ $post->correct_option == 'b' ? 'selected' : ''}}>Option B</option>
						<option value="c" {{ $post->correct_option == 'c' ? 'selected' : ''}}>Option C</option>
						<option value="d" {{ $post->correct_option == 'd' ? 'selected' : ''}}>Option D</option>
					</select>
				</div>

				<div class="col-md-12 mt-4">
					<label><b>Explanation: </b></label><br>
					<textarea name="explanation" rows="4" cols="120" value="{{ $post->explanation }}">{{ $post->explanation }}</textarea>
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