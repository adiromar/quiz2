@extends('layouts.admin')

@section('content')

<div class="container">
	
	<div class="card p-2">
		<div class="card-header"><b><i class="fa fa-money"></i> Payments</b></div>

		<table class="table table-bordered">
			
			<thead>
				<tr>
					<th>Fullname</th>
					<th>Email</th>
					<th>Contact</th>
					<th>Receipt</th>
				</tr>
			</thead>

			@if( count($payments) > 0 )

			<tbody>
				
				@foreach( $payments as $pay )

				<tr>
					<td>{{ $pay->fullname }}</td>
					<td>{{ $pay->email }}</td>
					<td>{{ $pay->mobile_no }}</td>
					<td>
						<a href="{{ asset( $pay->receipt ) }}" target="_blank">
							<img src="{{ asset( $pay->receipt ) }}" alt="" width="60" height="50">
						</a>
					</td>
				</tr>
	
				@endforeach

			</tbody>

			@else

			<tbody>
				<tr>
					<td colspan="4">No payments made so far.</td>
				</tr>
			</tbody>

			@endif

		</table>

	</div>

</div>

@endsection