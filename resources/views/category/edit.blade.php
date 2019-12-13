@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row">

		<div class="col-md-12 mt-4">
			<div class="card crd_border pb-4">
        		<div class="card-header"><h4><i class="mr-2 fa fa-edit"></i>Update Category</h4></div>
		<form action="{{ route('category.update', $category->id) }}" method="post" >
		{{ method_field('PUT') }}
		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

		<div class="col-md-6 mt-4">
			<label>Category Name: </label>
			<input type="text" name="category_name" value="{{ $category->category_name }}" class="form-control">
		</div>

		<div class="col-md-6 mt-4">
			<label>Main Category :</label>
			<select name="main_category_id" class="form-control">
				<option value="">Select</option>
				@if(count($main) > 0)
					@foreach($main as $m_cat)
						<option value="{{ $m_cat->id }}" {{ $m_cat->id == $category->main_category_id ? 'selected' : '' }}>{{ $m_cat->main_category_name }}</option>
					@endforeach
				@endif
			</select>
		</div>

		<div class="col-md-4 mt-4">
		<input type="submit" name="go" value="Submit" class="btn btn-primary btn-sm">
		</div>
		</form>
			</div>
		</div>
	</div>
	
</div>

@endsection