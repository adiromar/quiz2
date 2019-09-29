										{{--  Front End Section  --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- checking for admin rolw --}}
@if (auth()->check())
   @if (auth()->user()->isAdmin() == 1)
		@php
		$isadmin = true;
		@endphp
   @elseif (auth()->user()->isAdmin() == 2)
      	@php
		$isadmin = true;
		@endphp
   @else
   	  	@php
		$isadmin = false;
		@endphp
   @endif
@endif
{{-- end of checking roles --}}

	@yield('styles')

    <!-- CSRF Token -->
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <meta name="_token" content="{{csrf_token()}}" />
	<title>Apptitude Questions & Answers for your interview and Entrance Exam Preparations.</title>

	<link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
</head>
<body class="front-body">
	<div class="container">
		

		<div class="row">
		<div class="col-md-8">
		<a href="{{ url('/') }}"><img src="{{ asset('bix.gif') }}" class="img-responsive" width="150" height="70"></a>
		</div>

		<div class="col-md-4">
			@guest
    			<a href="{{ route('login') }}" class="btn btn-secondary btn-sm float-right mt-2"><i class="fa fa-user" aria-hidden="true"></i> Login</a>
   		 	@else
   		 		@if ($isadmin == true)
   		 		
   		 		<a href="{{ url('/dashboard') }}" class="btn btn-warning btn-sm mt-2" style="margin-left: 150px;"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>
   		 		@else

   		 		@endif

   		 		<a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-secondary btn-sm float-right mt-2"><i class="fa fa-key"></i> Log Out</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
            	</form>
   		 	@endguest
   		 </div>
   		</div>
	</div>
	<div class="container header-menu">
		<nav class="menu">
			<a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-bars"></i></a>
			@php
			use Illuminate\Support\Facades\Auth;
			use App\MainCategory;
			$caty = MainCategory::where('featured', '1')->take(10)->get();


			@endphp
			@if(count($caty) > 0)
            @foreach($caty as $cat)
            @php
            	$cat_name = mb_convert_case($cat->main_category_name, MB_CASE_TITLE);
            	// $cat_name = ucwords($cat->main_category_name);
            @endphp
			<a href="{{ url(''.$cat->slug.'/'.$cat->id.'') }}" class="link_a">{{ $cat_name }}</a>

			@endforeach
			@endif
			<a href="{{ url('/list-all') }}">Online Test</a>
			
		</nav>
		<div class="collapse" id="collapseExample">
                    <div class="card card-body">
                    	@if(count($caty) > 0)
            				@foreach($caty as $cat)
            				<h5 class="main-cat-list">{{ $cat->main_category_name }}</h5>
                    		
                    		@endforeach
                    	@endif
                    </div>
       		</div>

		<div class="pagehead"><h6 class="">Welcome to NepalQuiz.com !</h6></div>
		@include('inc.message')
		 @yield('content')
	</div>

<footer style="min-height: 75px">
	{{-- <div class="inner-footer">
		<div class="container-fluid footer-main">
			<a href="">Contact Us:</a><br>
			<a href="">Home</a>
			<a href="">Category</a>
			<h6>Developed By: company</h6>
		</div>
	</div> --}}
	
</footer>

	{{-- scripts --}}
	{{-- <script src="http://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script> --}}
	<script type="text/javascript" src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	
</body>
</html>