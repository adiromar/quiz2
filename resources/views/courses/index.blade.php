@extends('layouts.admin')

@section('content')

<div class="container">

	<div class="col-md-12 mt-4 mb-5">

	<div class="card">
        <div class="card-header">
        	<b>Courses:</b>
        	<a href="{{ route('courses.create') }}" class="btn btn-success btn-sm ml-4">+ Add</a>
        </div>
            <div class="card-body card-block">

				<table class="table table-condensed table-bordered">
					
					<thead>
						<tr>
							<th width="80">S.N.</th>
							<th>Title</th>
							<th>Topic Category</th>
							<th>Created at</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody>
					@if ( count($courses) == 0 )
						<tr>
							<td colspan="5">There are no courses at the moment.</td>
						</tr>
					@else
						<?php $i = 1; ?>
					    @foreach( $courses as $topic )
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $topic->title }}</td>
							<td>
								@foreach( $topic->topics as $t )
									
									{{ $t->title }}<br>

								@endforeach
							</td>
							<td>
								{{ $topic->created_at->toFormattedDateString() }}</td>
							<td>
								<a href="{{ route( 'courses.edit', $topic->id ) }}" class="btn btn-primary btn-sm">Edit</a>
								<a href="{{ route('courses.destroy', $topic->id) }}" class="btn btn-danger btn-sm">Delete</a>
							</td>
						</tr>
						<?php $i++; ?>
						@endforeach
					@endif
					</tbody>

				</table>

            </div>
        </div>
    </div>
</div>


@endsection
