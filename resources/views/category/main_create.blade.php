@extends('layouts.app')

@section('content')

<div class="container">

	<div class="col-md-12 mt-4 mb-5">
		<div class="card">

		<form action="{{ action('CategoryController@storemain') }}" method="post" >
		<div class="card-header">Create Main Category</div>
		
		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

		<div class="col-md-4 mt-4">
			<label>Main Category Name: </label>
			<input type="text" name="main_category_name" class="form-control">
		</div>

		<div class="col-md-4 mb-4">
		<input type="submit" name="go" value="Submit" class="btn btn-primary" style="margin-top: 22px;">
		</div>
		</form>

		</div>

		<div class="card mt-4">
			<div class="card-header">View Main Category</div>

			<table class="table table-bordered">
				<thead>
					<tr>
						<th>S.N</th>
						<th>Main Category Name</th>
						<th>Created Date</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					@if(count($main) > 0)
					<?php $m = 1; ?>
						@foreach($main as $mains)
						<tr>
							<td>{{ $m }}</td>
							<td>{{ $mains->main_category_name }}</td>
							<td>{{ $mains->created_at }}</td>
							<td></td>
						</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>

</div>

@endsection