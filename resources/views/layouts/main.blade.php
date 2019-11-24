<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html">
    <title>Apptitude Questions & Answers for your interview and Entrance Exam Preparations.</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <meta name="copyright" content="Quizzer is copyrighted to Encoderslab Pvt. Ltd.">

    @yield('seo')

    <meta name="robots" content="index,follow">    

    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Stardos+Stencil:400,700&display=swap" rel="stylesheet">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

		@yield('styles')
    <style media="screen">

      .modal-form input{
        display: block;
        width: 100%;
        padding-left: 10px;
      }
      .modal-form label{
        margin-bottom: 0px;
      }
      .modal-form .checkbox input{
        width: auto;
        display: inline;
      }
      .ques_wrap p{
        display: contents;
      }
    </style>
  </head>
  <body>
    <!-- Login modal -->
  	<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">

            <span class="login100-form-title p-b-49"> LOGIN </span>

            <div class="container" style="border:2px solid lightgrey">
              <div class="row">
                <div class="col-md-12 p-3 modal-form">
                  <form class="" action="{{ route('login') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                      <label for="user">Email Address:</label>
                      <input type="text" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                      <label for="pwd">Password:</label>
                      <input type="password" name="password" required>
                    </div>
                    <div class="form-group">
                      <div class="checkbox">
                          <label>
                              <input type="checkbox" name="remember" 
                              {{ old("remember") ? "checked" : "" }}> Remember Me
                          </label>
                      </div>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">
                          Login
                      </button>

                      <a href="" data-toggle="modal" data-target="#regModal" class="btn btn-link" id="register_here">Register Here</a>|
                      <a class="btn btn-link" href="{{ route('password.request') }}">
                          Forgot Your Password?
                      </a>
                    </div>
                    <div class="form-group">
                        <hr>
                        <p style="text-align: center;color: grey;">Or</p>

                        <a href="{{url('redirectfb')}}" class="btn btn-primary"><i class="fab fa-facebook-f"></i> &nbsp;Login with Facebook</a>

                        <span></span>
                        <a href="{{url('redirectgoogle')}}" class="btn btn-danger"><i class="fab fa-google"></i> Login with Google</a>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <div class="modal fade" id="regModal" tabindex="1" role="dialog" aria-labelledby="regModalTitle" aria-hidden="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <span class="login100-form-title p-b-49"> REGISTER </span>

          <div class="container" style="border:2px solid lightgrey">
            <div class="row">
              <div class="col-md-12 p-3 modal-form">
                <form class="" action="{{ route('register') }}" method="post">
                  {{ csrf_field() }}
                <div class="form-group">
                  <label for="">Name:</label>
                  <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" required>
                </div>
                <div class="form-group">
                  <label for="">Email Address:</label>
                  <input type="text" name="email" value="{{ old('email') }}" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <label for="">Phone No:</label>
                  <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                </div>
                <div class="form-group">
                  <label for="">Password:</label>
                  <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                  <label for="">Confirm Password:</label>
                  <input id="password-confirm" type="password" name="password_confirmation" placeholder="Enter Password Again" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
                    <a href="" id="login_here" class="btn btn-link">Login Here</a>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
	  <div class="bg-top navbar-light">
    	<div class="container">
    		<div class="row no-gutters d-flex align-items-center align-items-stretch">
    			<div class="col-md-4 d-flex align-items-center py-4">
    				<a class="navbar-brand" href="{{ url('/') }}">Quizzer Nepal</a>
    			</div>
	    		<div class="col-lg-8 d-block">
		    		<div class="row d-flex">
              <div class="col-md topper d-flex align-items-center justify-content-end pt-3">

                <p class="mb-0 d-block mr-2">
                  
                  <a href="{{ route('videos') }}" class="btn py-2 px-3 btn-danger">
                    <span><i class="fa fa-book-reader" aria-hidden="true"></i>&nbsp;Class Room</span>
                  </a>

                  <a href="{{ route('topics') }}" class="btn py-2 px-3 btn-dark">
                    <span><i class="fa fa-book" aria-hidden="true"></i>&nbsp;Courses</span>
                  </a>
                  
                </p>
                @guest
                <p class="mb-0 d-block">
		    		<a href="{{ route('login') }}" class="btn py-2 px-3 btn-primary" role="button" data-toggle="modal" data-target="#exampleModalLong">
		    			<span><i class="fa fa-user" aria-hidden="true"></i> Login</span>
		    		</a>
		    	</p>
                @endguest
                @auth
                <?php
					$aid = Auth::id();
					$rol = DB::table('role_user')->where('user_id', $aid)->first();
					$role = DB::table('roles')->where('id', $rol->role_id)->first();
				?>
	
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
                @endauth
              </div>

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
          
	        <li class="nav-item">
          @guest  
            <a href="{{ url('/list-all') }}" class="nav-link onlinetest" class="btn py-2 px-3 btn-primary" role="button" data-toggle="modal" data-target="#exampleModalLong"><i class="fas fa-tachometer-alt"></i>&nbsp;Online Test</a>
          @else
            <a href="{{ url('/list-all') }}" class="nav-link onlinetest" class="btn py-2 px-3 btn-primary"><i class="fas fa-tachometer-alt"></i>&nbsp;Online Test</a>
          @endguest
          </li>
          
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
                <?php
                  $mainid = $cat->main_category_id;
                  $main = App\MainCategory::find( $mainid );
                ?>
								<li><a href="{{ route('cat', [ $main->slug, $cat->slug, $cat->id, 1 ]) }}">
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
  						Copyright &copy;<script>document.write(new Date().getFullYear());</script>
              <a href="http://encoderslab.com" target="_blank">Encoderslab</a>,
              All rights reserved
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <script type="text/javascript">

    $('body').bind('copy',function(e) { e.preventDefault(); return false; }); 

    $('body').bind('paste',function(e) { e.preventDefault(); return false; });

    $('#register_here').click(function(e){
      $('#exampleModalLong').modal('toggle');
    });
    $('#login_here').click(function(e){
      e.preventDefault();
      $('#exampleModalLong').modal('toggle');
      $('#regModal').modal('toggle');
    });
  </script>

  <script>
    @if (Session::has('success'))

        toastr.success('{{ Session::get("success") }}');

    @endif
    @if (Session::has('info'))

        toastr.info('{{ Session::get("info") }}');

    @endif
    @if (Session::has('error'))

        toastr.error('{{ Session::get("error") }}');

    @endif

    @if ($errors->has('email'))
        toastr.error("{{ $errors->first('email') }}");
    @endif

    @if ($errors->has('password'))
        toastr.error("{{ $errors->first('password') }}");
    @endif

  </script>

  </body>
</html>
