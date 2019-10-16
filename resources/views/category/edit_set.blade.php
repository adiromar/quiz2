@extends('layouts.admin')
@section('styles')

<style>
	.order_form {
		display: inline-block;
	}
	.order_form .order{
		background-color: white !important;
		width: 80px;
		border-radius: 5px;
		padding: 2px 5px;
	}
</style>


@endsection

@section('content')
<div class="container">
	<div class="row">


	<div class="col-md-12 mt-4 mb-5">
		<div class="card">
			<form action="{{ route('questionset.update', $set->id) }}" method="post" class="">
				<div class="card-header mb-4">Edit Set</div>
				<input type="hidden" name="mainsetname" value="{{ $set->setname }}">
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
				{{ method_field('PUT') }}
				<div class="row">
					<div class="col-md-4 ml-3">
						<label>Question Set Name: </label>
						<input type="text" name="qst_set_name" value="{{ $set->setname }}" class="form-control">
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
							<!-- Calculate number of questions for each catid -->
							<?php $no_of_questions = ''; ?>
							@foreach( $setquestions as $n)
								@if( $n->category_id == $cat->id )

									<?php $no_of_questions = $n->no_of_question; ?>

								@endif
							@endforeach
							<td><input type="number" name="no_of_question[]" value="{{ $no_of_questions }}"></td>
							<input type="hidden" name="category_id[]" value="{{ $cat->id }}">
						</tr>
						@endforeach
					</table>

					<div class="col-md-4 mb-4">
						<input type="submit" name="go" value="Update" class="btn btn-primary" style="margin-top: 22px;">
					</div>
				</div>
			</form>
		</div>
	</div>

	</div>

</div>

@endsection
