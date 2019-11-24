@extends( 'layouts.main' )

@section('content')
	
	<div class="wrapper-title">
		<div class="row">
		<div class="col-md-12 text-center">
			<h4>Video Classes</h4>
		</div>
	</div>
	</div>

	<div class="wrapper">

		<div class="row">
		@if ( $videos )

		@foreach ( $videos as $vid )

			<div class="col-md-12 titles">
				<a href="{{ route('video.show', $vid->slug) }}">{{ $vid->title }}</a>
			</div>

		@endforeach

		@else
			<div class="col-md-12 titles text-center">
				<h4>Coming Soon!!</h4>
			</div>
		@endif
		</div>

	</div>	
	
@endsection

@section('styles')

<style>
	
	.wrapper, .wrapper-title{
		border: 1px solid lightgrey;
    	margin-top: 40px;
    	padding-bottom: 50px
	}
	.wrapper-title{
		padding: 10px 0px 5px 0px;
		border: 2px solid #343a40;
	}
	.wrapper-title h4 {
		color: #343a40;
    	font-weight: 700
	}
	.wrapper a{
		border-left: 3px solid #0d1128;
	    padding: 10px 15px;
	    background-color: #1b9ce3;
	    color: white;
	    font-weight: 700;
	}
	.wrapper a:hover{
		background-color: #dc3545;
	}
	.titles{
	    margin-bottom: 25px;
	}
</style>

@endsection