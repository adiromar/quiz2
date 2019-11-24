@extends( 'layouts.main' )

@section('content')

	<div class="wrapper">

		<div class="row">
		
			<div class="col-md-3">
				<img src="{{ asset( $course->featured ) }}" width="150" height="100" alt="No Image">
			</div>

			<div class="col-md-9">
				<h3>{{ $course->title }}</h3>
			</div>


		</div>

		
		
		
		<hr>

		<div class="content pt-4 pb-4">
			
			

			{!! $course->content !!}

		</div>

	</div>	
	
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