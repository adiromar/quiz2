@extends ('layouts.main')

@section ('content')


<div class="breadcrumb mb-4"><a href="{{ url('/') }}">Home</a>
	<span class="sp-angle">»</span>
	<span>Comprehensive</span>
</div>

<hr>

<div class="col-md-9">
	<div class="row">
	
	<?php if ( count($cats) > 0 ): ?>
		
		@foreach ( $cats as $cat )
			<div class="col-md-4">
				<span style="color: #e5e544"><i class="fa fa-folder"></i></span>
				<a href="{{ route('comprehensive.view', [$cat->slug, 1]) }}">&nbsp;{{ $cat->title }}</a>
			</div>
		@endforeach

	<?php else: ?>

		<p>No questions at the moment.</p>

	<?php endif ?>
		

	</div>
</div>

@endsection