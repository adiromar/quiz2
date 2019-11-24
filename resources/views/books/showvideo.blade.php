@extends( 'layouts.main' )

@section('content')

	<div class="wrapper">

		<div class="row">
		
			<div class="col-md-12">
				<h5><strong>{{ $video->title }}</strong></h5>
				<hr>
			</div>

			<hr>

		</div>

		<div class="row">
		
			<div class="col-md-12 video-wrap">
				
				<iframe src="{{ $video->url }}" frameborder="1" allowfullscreen="1"></iframe>

			</div>

		</div>

		<div class="row">
			
			<div class="col-md-12">
				
				<h5><strong>Description:</strong></h5>

				<p>
					{{ $video->description }}
				</p>

			</div>

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
	.video-wrap{
		padding-top: 20px;
		padding-bottom: 20px;
	}
	.video-wrap iframe{
		width:100%;height:500px
	}
</style>

@endsection