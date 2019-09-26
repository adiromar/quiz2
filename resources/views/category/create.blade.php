@extends('layouts.admin')

@section('content')

<div class="container">

	<div class="col-md-12 mt-4 mb-5">
		<div class="card">

		<form action="{{ action('CategoryController@store') }}" method="post" >
		<div class="card-header">Create Category</div>
		
		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

		<div class="col-md-4 mt-4">
			<label>Category Name: </label>
			<input type="text" name="category_name" class="form-control">
		</div>

		<div class="col-md-4 mt-4">
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

		<div class="col-md-4 mb-4">
		<input type="submit" name="go" value="Submit" class="btn btn-primary" style="margin-top: 22px;">
		</div>
		</form>

		</div>
	</div>

</div>

@endsection