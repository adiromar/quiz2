@extends( 'layouts.main' )

@section('seo')

	<meta name="description" content="Quizzer Nepal | List of {{ $topic }} Courses You can Choose from.">
	<meta name="keywords=" content="quizzer,quizzer nepal,quiz nepal,nepal quiz,class,courses,topics,learning,teaching,@if ( count($courses) > 0 )@foreach( $courses as $c ){{ $c->slug . ','}}@endforeach @endif ">

@endsection

@section('content')
	<div class="wrapper-title">
		<div class="row">
		<div class="col-md-12 text-center">
			<h4>{{ $topic }} Courses</h4>
		</div>
	</div>
	</div>
	
	@if ( count( $courses ) > 0 )

	<div class="wrapper">
		<div class="row">
		
			@foreach ( $courses as $c )
			<div class="col-md-6">
				<div class="courses">
					@if ( $c->featured )
						<img src="{{ asset( $c->featured ) }}" alt="" width="50" height="50">
					@endif
					<a href="{{ route('course.view', $c->slug) }}">{{ $c->title }}</a>
				</div>
			</div>
			@endforeach
		
		</div>
	</div>	
	@else
	<div class="row">
		<div class="col-md-12">
			<div class="courses">
				<h4>Coming Soon!!!</h4>
			</div>
		</div>
	</div>
		
	@endif
		

@endsection

@section('styles')

<style>
	.courses{
		/*background-color: #008b8b73;*/
	    color: white;
	    padding: 5px 5px;
	    border-left: 3px solid #0d1128;
	    border-right: 3px solid #0d1128;
		border-top: 1px solid lightgrey;
		border-bottom: 1px solid lightgrey;
	    text-align: center;
	}
	.courses a{
		color: #0d1128;
    	font-weight: 600;
    	display: block;
	}
	.wrapper, .wrapper-title{
		border: 1px solid lightgrey;
    	margin-top: 40px;
    	padding-bottom: 50px
	}
	.wrapper-title{
		padding: 10px 0px 5px 0px;
		background-color: #0d1128;
	}
	.wrapper-title h4 {
		color: white;
	}
</style>

@endsection