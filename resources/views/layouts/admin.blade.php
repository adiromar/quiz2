        {{-- backend menu --}}
@if (auth()->check())
   @if (auth()->user()->isAdmin() == 1)
      
   @elseif (auth()->user()->isAdmin() == 2)
   @else
      @php 
      echo "Forbidden Access";
      // return redirect()->back();
      return redirect()->route('home');
      @endphp
   @endif
@endif


<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- <title>{{ config('app.name', 'Bix') }}</title> --}}
    <title>{{ config('app.name') }} - {{ config('app.subtitle') }}</title>
    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('admin/assets/css/normalize.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/ci-skin-elastic.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/scss/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/lib/chosen/chosen.min.css') }}" rel="stylesheet">
</head>
<body>
       <!-- Left Panel -->

    <aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">

            <div class="navbar-header">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="{{ route('dash') }}">Quiz</a>
                <a class="navbar-brand hidden" href="{{ route('dash') }}">QA</a>
            </div>

            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ route('dash') }}"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                    </li>

                    {{-- <h3 class="menu-title">Main Category</h3><!-- /.menu-title --> --}}
                    {{-- <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-plus"></i>Create / View</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="{{url('maincategory/create')}}">Main Category</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="{{url('category/index')}}">Category</a></li>
                        </ul>
                    </li> --}}

                    <li><a href="{{url('maincategory/create')}}"><i class="menu-icon fa fa-list"></i>Main Category</a></li>
                    <li><a href="{{url('category/index')}}"><i class="menu-icon ti-view-grid"></i> Category</a></li>

                    <li><a href="{{route('posts.index')}}"><i class="menu-icon ti-file"></i> Posts</a></li>

                    <li><a href="{{url('posts/question_report')}}"><i class="menu-icon fa fa-question-circle"></i>Question Feedback</a></li>

                    <li><a href="{{route('question')}}"><i class="menu-icon fa fa-question-circle"></i>Question Set</a></li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->

    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">
            @php
                if(empty($title)){
                    $title = '';
                }
            @endphp

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="ti-layout-slider"></i></a>
                    <h4>{{ $title }}</h4>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b>Welcome, {{ Auth::user()->name }}</b> <i class="ti-arrow-circle-down"></i>
                            {{-- <img class="user-avatar rounded-circle" src="{{ asset('admin/images/admin.jpg') }}" alt="User Avatar"> --}}
                        </a>

                        <div class="user-menu dropdown-menu">

                                <a class="nav-link" href="{{ route('home') }}"><i class="ti-home"></i> Homepage </a>

                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                </form>
                        </div>
                    </div>

                    <div class="language-select dropdown" id="language-select">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown"  id="language" aria-haspopup="true" aria-expanded="true">
                            <i class="flag-icon flag-icon-us"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="language" >
                            <div class="dropdown-item">
                                <span class="flag-icon flag-icon-fr"></span>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-es"></i>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-us"></i>
                            </div>
                            <div class="dropdown-item">
                                <i class="flag-icon flag-icon-it"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </header><!-- /header -->
        <!-- Header-->

        {{-- <div class="breadcrumbs">
            <div class="col-md-12 col-lg-12 col-sm-4">
                <div class="page-header pt-2">
                    <div class="page-title"> --}}
                        @include('inc.message')
                    {{-- </div>
                </div>
            </div>
        </div> --}}

{{-- @include('inc.message') --}}
@yield('content')



    </div><!-- /#right-panel -->

    <!-- Right Panel -->


    <script src="{{ asset('admin/assets/js/vendor/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugins.js') }}"></script>
    <script src="{{ asset('admin/assets/js/main.js') }}"></script>
    <script src="{{ asset('admin/assets/js/lib/chosen/chosen.jquery.min.js') }}"></script>
    


</body>
</html>