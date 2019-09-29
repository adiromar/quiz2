@extends('layouts.main')

@section('styles')

<style>
	.sets span, .sets a{
		font-weight: 600;font-size: 14px
	}
	.sets a{
		color:chocolate;
	}
</style>

@endsection

@section('content')


<div class="col-md-12">
	<div class="row box_wrap">
	
		<table class="table table-condensed table-sm table-striped">

			<tbody>
				@if( !empty($sets) )
				<thead>
					<tr>
						<th colspan="2">
							Choose a Set of Questions Here
						</th>
					</tr>
				</thead>
				<?php $i = 1; ?>
				@foreach($sets as $s)
					<tr class="sets">
						<td width="50"><span>{{ $i }}.</span></td>
						<td>
							<a href="{{ route('set.view', [$s->slug, 1]) }}">{{ $s->setname }}</a>
						</td>
					</tr>
				<?php $i++; ?>
				@endforeach

				@else
				<tr>
					<td colspan="2">There are no QUIZ sets right now. COMING SOON!</td>
				</tr>
				@endif
			</tbody>
			
		</table>

	</div>
</div>


@endsection