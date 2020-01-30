@extends('layouts.admin')

@section ('styles')

<style>
	.card-title{ font-weight: 600;font-size: 18px; padding: 20px }
	.card-content{ padding: 15px 25px; }
	.listwrap{ list-style: none;
    height: 115px;
    overflow-x: auto; }
    .fa-eye{ color: blue }
</style>

@endsection

@section('content')

<div class="container">
<div class="card">
<div class="card-title">User: <span style="color: maroon">{{ $user->name }}</span></div>
<div class="card-content">

<table class="table table-bordered table-hover table-responsive table-striped">
						<thead class="thead-dark">
							<tr>
								<th width="5%">S.N</th>
								<th width="40%">Post Name</th>
								<th width="20%">Category Name</th>
								<th width="20%">All Options</th>
								<th width="5%">Correct Option</th>
								<th width="5%">Level</th>
								<th width="10%">Created Date</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@if(count($posts) > 0)
							@foreach($posts as $cat)
								<tr>
									<td>{{ $i }}</td>
									<td>{{ $cat->post_name }}</td>
									<td>{{ $cat->category_name }}</td>
									<td>A. {{ $cat->option_a }}<br>
										B. {{ $cat->option_b }}<br>
										C. {{ $cat->option_c }}<br>
										D. {{ $cat->option_d }}
									</td>
									<td>{{ $cat->correct_option }}</td>
									<td>{{ $cat->level }}</td>
									<td>{{ $cat->created_at }}</td>
								</tr>

								<?php $i++; ?>
								@endforeach
						</tbody>
					</table>

					{{-- <div class="col-md-12 pagination-links-url"> --}}
						 {{ $posts->links()}}
					{{-- </div> --}}
							@else
								<table><tr><td colspan="5">No Posts Found</td></tr></table>
							@endif

</div>
</div>
</div>


@endsection