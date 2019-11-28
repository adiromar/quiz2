@extends('layouts.admin')

@section('content')

<div class="container">
	
	<div class="row">
		
		<div class="col-md-12 mt-4 mb-5">
			
			<div class="card crd_border p-4">
				<div class="row pb-3">
					<div class="col-md-4">
						<h5>Comprehensive Questions:</h5>
					</div>
					<div class="col-md-3">
						<a href="{{ route('comprehensive.create') }}" class="btn btn-success">+ Add Question</a>
					</div>
				</div>
			<table class="table table-condensed table-bordered">
				
				<thead>
					<tr>
						<th>Title</th>
						<th>SubQuestion Ids</th>
						<th>Actions</th>
					</tr>
				</thead>

				<tbody>
					@if ( count( $all ) > 0 )

					@foreach ( $all as $a )

						<tr>
							<td>{{ $a->title }}</td>
							<td>
								@foreach ( $a->posts as $p )

								{{ $p->id . ", " }}

								@endforeach
							</td>
							<td>
								<a href="" class="btn btn-sm btn-info">Edit</a>
								<a href="" class="btn btn-sm btn-warning">Delete</a>
							</td>
						</tr>
					
					@endforeach

					@else

					<tr>
						<td colspan="3">No questions at the moment</td>
					</tr>

					@endif

				</tbody>
				
			</table>

			</div>

		</div>

	</div>

</div>

@endsection