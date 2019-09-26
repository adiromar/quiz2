@extends('layouts.admin')

@section('content')

<div class="container">

	<div class="col-md-12 mt-4 mb-5">
		<div class="card">

		<form action="{{ action('CategoryController@store_questionsets') }}" method="post" class="">
		<div class="card-header mb-4">Create Category Set</div>
		
		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

		<div class="row">
		<div class="col-md-4 ml-3">
			<label>Question Set Name: </label>
			<input type="text" name="qst_set_name" class="form-control">
		</div>
		</div>

		<div class="col-md-12 mt-4">
		<table class="table table-bordered table-striped">
			<tr>
				<th>Category</th>
				<th>No. Of Questions</th>
			</tr>
@foreach($category as $cat)
		<tr>
			<th>{{ $cat->category_name }}</th>
			<td><input type="number" name="no_of_question[]" class=""></td>
			<input type="hidden" name="category_id[]" value="{{ $cat->id }}">
		</tr>
@endforeach
		</table>
		</tr>

		<div class="col-md-4 mb-4">
		<input type="submit" name="go" value="Submit" class="btn btn-primary" style="margin-top: 22px;">
		</div>
		</form>

		</div>

	</div>
</div>

@endsection