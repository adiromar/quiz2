@extends('layouts.admin')

@section ('styles')

<style>
	.card-title{ font-weight: 600;font-size: 18px; padding: 20px }
	.card-content{ padding: 15px 25px; }
</style>

@endsection

@section('content')

<div class="container">
	<div class="card">
		<div class="card-title">Users Statistics</div>
		<div class="card-content">
			
			<table class="table table-bordered">
				
				<thead>
					<tr>
						<th width="70">S.N.</th>
						<th>Name</th>
						<th>No. of questions</th>
					</tr>
				</thead>
				<tbody>
					@foreach( $users as $user )
						@if ( $user->checkRole( $user->id ) == 'Admin' )
							<tr>
								<td>{{ $user->id }}</td>
								<td>{{ $user->name }}</td>
								<td>{{ App\Posts::where('user_id', $user->id)->get()->count() }}</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>

		</div>
	</div>
</div>


@endsection