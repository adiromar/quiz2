@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row">

	@if(Session::has('message'))
        <p >{{ Session::get('message') }}</p>
     @endif


		<div class="col-md-12 mt-4">
			<div class="card crd_border">
        		<div class="card-header"><h4>Question Report/Feedback</h4></div>
					<table class="table table-bordered table-responsive table-striped">
						<thead class="thead-light">
							<tr>
								<th>S.N</th>
								<th>Post Id</th>
								<th>Post Name</th>
								<th>Category Name</th>
								<th>User Name</th>
								<th>Email</th>
								<th>Message</th>
								<th>Created Date</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@if(count($report) > 0)
							@foreach($report as $rep)
								<tr>
									<td>{{ $i }}</td>
									<td>{{ $rep->post_id }}</td>
									<td>{{ $rep->post_name }}</td>
									<td>{{ $rep->cat_name }}</td>
									<td>{{ $rep->report_username }}</td>
									<td>{{ $rep->report_email }}</td>
									<td>{{ $rep->message }}</td>
									<td>{{ $rep->created_at }}</td>
								</tr>

								<?php $i++; ?>
								@endforeach
							
								
						</tbody>
					</table>

					{{ $report->links()}}
							@else
								<table><tr><td colspan="5">No Report Found</td></tr></table>
							@endif
			</div>
		</div>
	</div>
	

</div>

@endsection