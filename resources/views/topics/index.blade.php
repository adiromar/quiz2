@extends('layouts.admin')

@section('content')

<div class="container">

	<div class="col-md-12 mt-4 mb-5">

	<div class="card">
        <div class="card-header"><b><i class="ti-pencil-alt"></i> Add a Topic</b></div>
            <div class="card-body card-block">
                <form action="{{ route('topics.store') }}" method="post" class="">

                	<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                    <div class="form-group">
                        <div class="input-group">
                           <div class="input-group-addon">Display Title:</div>
                              <input type="text" id="maincat" name="topic_title" class="form-control">
                              <div class="input-group-addon"><i class="fa fa-list"></i></div>
                            </div>
                          </div>
                          <div class="form-actions form-group">
                            <button type="submit" name="go" class="btn btn-primary btn-sm">Submit</button>
                          </div>
                </form>
        </div>
    </div>


	<div class="row">

	<div class="col-md-12 mt-4">
	<div class="card crd_border">

	<div class="panel-body">

	<div class="container p-3">
		<h4>Books' Topics</h4>

		<div class="row mt-3">
			
			<div class="col-md-12">
				
				<table class="table table-condensed table-bordered">
					
					<thead>
						<tr>
							<th width="80">S.N.</th>
							<th>Title</th>
							<th>#</th>
							<th>Created at</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody>
					@if ( count($topics) == 0 )
						<tr>
							<td colspan="4">There are no topics at the moment.</td>
						</tr>
					@else
						<?php $i = 1; ?>
					    @foreach( $topics as $topic )
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $topic->title }}</td>
							<td>0</td>
							<td>
								{{ $topic->created_at->toFormattedDateString() }}</td>
							<td>
								<a href="{{ route('topics.destroy', $topic->id) }}" class="btn btn-danger btn-sm">Delete</a>
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

	</div>
	</div>
	</div>

</div>

@endsection
