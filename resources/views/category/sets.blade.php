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
		<div class="col-md-12 mb-5 p-2">
			<div class="card p-2">

				<div class="card-header mb-4">View Sets</div>
			<form action="{{ route('change.order') }}" method="post" class="order_form">
				{{ csrf_field() }}
				<table class="table table-condensed table-bordered table-striped">
					<thead>
						<tr>
							<th>Setname</th>
							<th width="200">
								Order &nbsp;&nbsp;
								<input type="submit" name="changeorder" class="btn btn-sm btn-primary" value="Change Order">
							</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody>
						@foreach( $sets as $set )

						<tr>
							<td>{{ $set->setname }}</td>
							<td>

									<input type="text" name="order[]" class="order" value="{{ $set->order }}" required>
									<input type="hidden" name="setids[]" value="{{$set->id}}">

							</td>
							<td>
								<a href="{{ route('questionset.edit', $set->id) }}"><i class="fa fa-edit fa-2x"></i></a>
								&nbsp;&nbsp;
								<a href="{{ route('questionset.destroy', $set->id) }}"><i class="fa fa-trash " style="color:red"></i></a>
							</td>
						</tr>

						@endforeach
					</tbody>

				</table>
			</form>

			</div>
		</div>
	</div>

</div>

@endsection
