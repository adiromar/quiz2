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
<div class="card-title">Users Statistics</div>
<div class="card-content">

<table class="table table-bordered">

<thead>
<tr>
	<th width="70">S.N.</th>
	<th>Name</th>
	<th></th>
	<th>Tot</th>
</tr>
</thead>
<tbody>
@foreach( $users as $user )
	@if ( $user->checkRole( $user->id ) == 'Admin' )
		<tr>
			<td>{{ $user->id }}</td>
			<td>{{ $user->name }}</td>
			
			<td>
				
			<?php 
			$posts = App\Posts::where('user_id', $user->id)->get();
			if ( $posts->count() > 0 ) {

				echo "<ul class='listwrap'>";
				foreach ($cats as $m) {

				$p = $m->posts()->where('user_id', $user->id)->get()->count();

					if ( $p > 0 ) {
			?>
					<li>
						{{ $m->category_name }}
					
						( {{$p}} <a href="{{ route('view.user.posts', [$user->id,$m->id]) }}">
							<i class="fa fa-eye"></i>
						</a> &nbsp;)
					</li>
			<?php

					}
				}
			}
				echo "</ul>";
			?>

			</td>

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