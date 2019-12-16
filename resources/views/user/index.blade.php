@extends ('layouts.admin')

@section('styles')
<style>
	.role-btn, .role-btn:hover{ 
	    padding: 4px 6px;
	    color: white;
	    border-radius: 5px;
	}
	.promote{
		background-color: #272c33;
	}
	.demote{
		background-color: darkred;
	}
	.chkrole{
		color: chocolate;
    	font-weight: 700;
	}
</style>
@endsection

@section('content')


<div class="container">
	<div class="card">
		<div class="card-body">
			<div class="card-title"><h5>Manage Users' Roles:</h5></div>
			<div class="card-text">
				
				<table class="table table-condensed table-bordered">
					
					<thead class="table-primary">
						<tr>
							<th>Name</th>
							<th>Role</th>
							<th>Change Role</th>
						</tr>
					</thead>
					<tbody>
						@foreach ( $users as $user )

							<tr>
								<td>{{ $user->name }}</td>
								<td class="chkrole">{{ $user->checkRole( $user->id ) }}</td>
								<td>
									@if( $user->checkRole( $user->id ) == 'Admin' )
										<a href="{{ route('update.userrole', [$user->id, 'promote']) }}" class="role-btn promote">Promote</a>
									@elseif( $user->checkRole( $user->id ) == 'SuperAdmin' )
										<a href="{{ route('update.userrole', [$user->id, 'demote']) }}" class="role-btn demote">Demote</a>
									@endif
								</td>
							</tr>

						@endforeach
					</tbody>

				</table>

			</div>	
		</div>
	</div>
</div>

@endsection