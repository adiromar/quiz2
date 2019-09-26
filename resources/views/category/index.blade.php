@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row">

		<div class="col-md-12 mt-4">
			<div class="card crd_border pb-4">
        		<div class="card-header"><h4><i class="mr-2 fa fa-plus"></i>Create Category</h4></div>
        		{{-- <div class="row"> --}}
					{{-- <div class="card-body col-md-6">
						<a href="{{ url('category/create') }}" class="btn btn-success btn-sm ml-4">+ Add New Category</a>
					</div> --}}

					{{-- <div class="col-md-5 float-right">
						<form method='post' action='/uploadCategory' enctype='multipart/form-data' >
       					{{ csrf_field() }}
						<label class="col-md-12">Upload Category (CSV Format): </label>
						<input type="file" name="file" class="btn btn-light">
						<input type="submit" name="upload" value="Upload" class="btn btn-primary ml-2">
						</form>
					</div> --}}
		<form action="{{ action('CategoryController@store') }}" method="post" >
		
		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

		<div class="col-md-6 mt-4">
			<label>Category Name: </label>
			<input type="text" name="category_name" class="form-control">
		</div>

		<div class="col-md-6 mt-4">
			<label>Main Category :</label>
			<select name="main_category_id" class="form-control">
				<option value="">Select</option>
				@if(count($main) > 0)
					@foreach($main as $m_cat)
						<option value="{{ $m_cat->id }}">{{ $m_cat->main_category_name }}</option>
					@endforeach
				@endif
			</select>
			{{-- <input type="text" name="main_category_name" class="form-control"> --}}
		</div>

		<div class="col-md-4 mt-4">
		<input type="submit" name="go" value="Submit" class="btn btn-primary btn-sm">
		</div>
		</form>


				{{-- </div> --}}
			</div>
		</div>

		<div class="col-md-12 mt-4">
			<div class="card crd_border">
        		<div class="card-header"><h4><i class="mr-2 ti-view-list"></i>View Category</h4></div>
					<table class="table table-bordered table-responsive table-striped">
						<thead class="thead-dark">
							<tr>
								<th width="5%">S.N</th>
								<th width="35%">Category Name</th>
								<th width="15%">Category Id</th>
								<th width="20%">Created Date</th>
								<th width="10%">Status</th>
								<th width="15%">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@if(count($category) > 0)
							@foreach($category as $cat)
								<tr>
									<td>{{ $i }}</td>
									<td>{{ $cat->category_name }}</td>
									<td>{{ $cat->id }}</td>
									<td>{{ $cat->created_at }}</td>
									<td>
										<form action="{{ action('CategoryController@featured_cat', $cat->id) }}" method="post" >
											{{ csrf_field() }}
											{{ method_field('put') }}
											{{-- <input type="checkbox" name="status" value="" {{ $cat->featured == '1' ? 'checked' : ''}} id="check_feat" class="check_feat" onchange="this.form.submit()"> --}}
											<select name="status" onchange="this.form.submit()" class="drp_col">
												<option value="0" {{ $cat->featured == '1' ? 'selected' : ''}}>Off</option>
												<option value="1" {{ $cat->featured == '1' ? 'selected' : ''}}>On</option>
											</select>
											  <input type="hidden" name="featured" value="{{ $cat->featured }}">
											  <input type="hidden" name="cat_id" value="{{ $cat->id }}" id="cat_id">
										</form></td>
									<td>
										<form method="POST" class="float-right" action="{{ action('CategoryController@destroy', $cat->id) }}">
											{{ csrf_field() }}
											{{ method_field('delete') }}
										<input type="submit" onclick="return check_del();" value="Delete" class="btn btn-danger btn-sm">
										</form>
									</td>
								</tr>

								<?php $i++; ?>
								@endforeach
							
								{{ $category->links()}}
							@else
								<tr><td colspan="3">No Categories Found</td></tr>
							@endif
						</tbody>
					</table>
			</div>
		</div>
	</div>
	
</div>

{{-- <script src="http://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script> --}}
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.check_feats').on('change', function (e){

		// $.ajaxSetup({
  //           headers: {
  //               'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
  //           }
  //       })
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		e.preventDefault();

		if(this.checked) {
			var feat_val = 1;
        	console.log('checked');
    	}else{
    		var feat_val = 0;
    		console.log('un-checked');
    	}
		var formData = {
			_token: CSRF_TOKEN,
            featured: feat_val,
            cat_id: $('#cat_id').val(),
        }
        console.log(formData);
		$.ajax({
			url: "{{ url('/category/featured') }}",
			method: 'post',
			dataType: 'json',
			data: formData,
		success: function(result){
			console.log(result);
		}
		});
	});
});

function check_del(){
    var r=confirm("Confirm Delete this Data?")
        if (r==true)
          window.location = url+"pages/delete_sin/"+title+id;
        else
          return false;
  }
</script>
@endsection