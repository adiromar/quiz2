@extends( 'layouts.main' )

@section('content')

	@if ( count($topics) > 0 )
	<div class="wrapper">
		<div class="row">
			@foreach ( $topics as $topic )
			<div class="col-md-3">
				<div class="topics">
					<a href="{{ route('topic.view', $topic->slug) }}">{{ $topic->title }}</a>
				</div>
			</div>
			@endforeach

		</div>
	</div>	
	@else
	<div class="wrapper">
		<div class="row">
			<div class="col-md-12">
				<h4>Coming Soon !!!</h4>
			</div>
		</div>
	</div>
	@endif

@endsection

@section('styles')

<style>
	.topics{
		padding: 20px 15px;
	    text-align: center;
	    background-color: #1b9ce3;
	    border-radius: 3px;
	    margin-top: 20px;
	    height: 80px;
	    font-weight: 700;
	    border: 2px solid #343a40;
	}
	.topics a{ color: white;  }
	.topics:hover{
		background-color: #dd3333;
	}
	.wrapper{
		border: 1px solid lightgrey;
    	margin-top: 60px;
	}
</style>

@endsection