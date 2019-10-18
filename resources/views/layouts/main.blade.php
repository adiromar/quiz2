<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Apptitude Questions & Answers for your interview and Entrance Exam Preparations.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('consolution/css/open-iconic-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('consolution/css/animate.css') }}">

    <link rel="stylesheet" href="{{ asset('consolution/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('consolution/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('consolution/css/magnific-popup.css') }}">

    <link rel="stylesheet" href="{{ asset('consolution/css/aos.css') }}">

    <link rel="stylesheet" href="{{ asset('consolution/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('consolution/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('consolution/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('consolution/css/style.css') }}">
		<link rel="stylesheet" href="{{ asset('consolution/css/custom.css') }}">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.0/css/all.css" integrity="sha384-Mmxa0mLqhmOeaE8vgOSbKacftZcsNYDjQzuCOm6D02luYSzBG8vpaOykv9lFQ51Y" crossorigin="anonymous">
		<link href="{{ asset('css/home.css') }}" rel="stylesheet">

		@yield('styles')

  </head>
  <body>
	  <div class="bg-top navbar-light">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-center align-items-stretch">
    			<div class="col-md-4 d-flex align-items-center py-4">
    				<a class="navbar-brand" href="{{ url('/') }}">Quizzer Nepal</a>
    			</div>
	    		<div class="col-lg-8 d-block">
		    		<div class="row d-flex">

						@guest
					    <div class="col-md topper d-flex align-items-center justify-content-end pt-3">
					    	<p class="mb-0 d-block">
					    		<a href="{{ route('login') }}" class="btn py-2 px-3 btn-primary">
					    			<span><i class="fa fa-user" aria-hidden="true"></i> Login</span>
					    		</a>
					    	</p>
					    </div>
						@else
						<?php
							$aid = Auth::id();
							$rol = DB::table('role_user')->where('user_id', $aid)->first();
							$role = DB::table('roles')->where('id', $rol->role_id)->first();
						?>

						<div class="col-md topper d-flex align-items-center justify-content-end pt-3">

							<?php if ( $role->role == 'SuperAdmin' || $role->role == 'Admin' ): ?>

				    		<a href="{{ url('/dashboard') }}" class="btn py-2 px-3 btn-primary">
				    			<span><i class="fab fa-artstation"></i></i> Dashboard</span>
				    		</a>

							<?php endif; ?>

							<a href="{{ route('logout') }}" class="btn py-2 px-3 btn-warning ml-2" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
								<span style="color:#8b4513"><i class="fas fa-sign-out-alt"></i> Sign Out</span>
								<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
									{{ csrf_field() }}
            		</form>
							</a>

				    </div>

						@endguest

				    </div>
			    </div>
		    </div>
		  </div>
    </div>
	  <nav class="navbar navbar-expand-lg navbar-dark bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container d-flex align-items-center">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>
	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav mr-auto">
					<?php $caty = App\MainCategory::where('featured', '1')->take(10)->get(); ?>
					@if(count($caty) > 0)
						@foreach( $caty as $cat )
						<?php $cat_name = mb_convert_case($cat->main_category_name, MB_CASE_TITLE); ?>
						<li class="nav-item"><a href="{{ url(''.$cat->slug.'/'.$cat->id.'') }}" class="nav-link pl-0">
							{{ $cat_name }}
						</a></li>
						@endforeach
					@endif
					@auth
	          <li class="nav-item"><a href="{{ url('/list-all') }}" class="nav-link onlinetest"><i class="fas fa-tachometer-alt"></i>&nbsp;Online Test</a></li>
					@endauth
					</ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
		<div class="container" style="padding-bottom: 50px;">

			@yield('content')

		</div>

		<footer class="ftco-footer ftco-bg-dark ftco-section">
      <div class="container">
        <div class="row mb-5">
          <div class="col-md-4 col-lg-4">
            <div class="ftco-footer-widget mb-5">
            	<h2 class="ftco-heading-2">Have a Questions?</h2>
            	<div class="block-23 mb-3">
	              <ul>
	                <li><span class="icon icon-map-marker"></span><span class="text">Tinkuney, Koteswor, Nepal</span></li>
	                <li><a href="#"><span class="icon icon-phone"></span><span class="text">+2 392 3929 210</span></a></li>
	                <li><a href="#"><span class="icon icon-envelope"></span><span class="text">encoderslab@gmail.com</span></a></li>
	              </ul>
	            </div>
            </div>
          </div>
					<div class="col-md-1 col-lg-1"></div>
          <div class="col-md-4 col-lg-3">
						<div class="ftco-footer-widget mb-5">
            	<h2 class="ftco-heading-2 mb-0">Connect With Us</h2>
            	<ul class="ftco-footer-social list-unstyled float-md-left float-lft mt-3">
                <li class="ftco-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                <li class="ftco-animate"><a href="#"><span class="icon-instagram"></span></a></li>
              </ul>
            </div>
          </div>
					<div class="col-md-1 col-lg-1"></div>
          <div class="col-md-4 col-lg-3">
            <div class="ftco-footer-widget mb-5 ml-md-4">
              <h2 class="ftco-heading-2">Recent Categories</h2>
              <ul class="list-unstyled">
							@foreach(App\Category::orderBy('id', 'desc')->get()->take(5) as $cat)
								<li><a href="#">
									<span class="ion-ios-arrow-round-forward mr-2"></span>{{ $cat->category_name }}</a>
								</li>
							@endforeach
              </ul>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 text-center">

            <p>
  						Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
  				  </p>
          </div>
        </div>
      </div>
    </footer>



  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>


  <script src="{{ asset('consolution/js/jquery.min.js') }}"></script>
  <script src="{{ asset('consolution/js/jquery-migrate-3.0.1.min.js') }}"></script>
  <script src="{{ asset('consolution/js/popper.min.js') }}"></script>
  <script src="{{ asset('consolution/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('consolution/js/jquery.easing.1.3.js') }}"></script>
  <script src="{{ asset('consolution/js/jquery.waypoints.min.js') }}"></script>
  <script src="{{ asset('consolution/js/jquery.stellar.min.js') }}"></script>
  <script src="{{ asset('consolution/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('consolution/js/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('consolution/js/aos.js') }}"></script>
  <script src="{{ asset('consolution/js/jquery.animateNumber.min.js') }}"></script>
  <script src="{{ asset('consolution/js/scrollax.min.js') }}"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
  <script src="{{ asset('consolution/js/google-map.js') }}"></script>
  <script src="{{ asset('consolution/js/main.js') }}"></script>

  </body>
</html>
