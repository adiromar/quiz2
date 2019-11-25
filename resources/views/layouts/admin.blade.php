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

    @yield('styles')
    <style>
        .fileinp{background-color: #272c33e6;color: white;cursor: pointer;}
        #addQues{ background-color: #272c33; padding: 5px 20px; color: white; }
        .append{ padding: 15px 15px;border: 1px solid lightgrey;margin-top: 10px;margin-bottom: 15px; }
        label{ font-weight: 600 }
    </style>

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

                    <li><a href="{{route('posts.index')}}"><i class="menu-icon ti-file"></i> Questions</a></li>

                    <li><a href="{{route('posts.comprehensive')}}"><i class="menu-icon ti-files"></i> Comprehensive</a></li>
                    
                    <li style="color: white"><strong>Books</strong></li>

                    <li><a href="{{ route('topics.index') }}"><i class="menu-icon fa fa-book"></i>Topics</a></li>
                    <li><a href="{{ route('courses.index') }}"><i class="menu-icon fa fa-university"></i>Courses</a></li>

                    <li style="color: white"><strong>Sets</strong></li>
                    
                    <li><a href="{{ route('question') }}"><i class="menu-icon fa fa-question-circle"></i>Add Question Set</a></li>
                    <li><a href="{{ route('sets') }}"><i class="menu-icon fa fa-eye"></i>View Sets</a></li>
                    
                    <li><a href="{{ route('video.create') }}"><i class="menu-icon fa fa-youtube"></i>Add Video URL</a></li>

                    <li><a href="{{ route('payment.receipts') }}"><i class="menu-icon fa fa-money"></i>User Payments</a></li>

                    <li><a href="{{url('posts/question_report')}}"><i class="menu-icon fa fa-question-circle"></i>Question Feedback</a></li>

                    <li><a href="{{ route('stats') }}"><i class="menu-icon fa fa-stack-exchange" aria-hidden="true"></i> Stats</a></li>

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

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="http://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E=" crossorigin="anonymous"></script>
    <script>
        
        $('#addQues').click(function(e){    
            e.preventDefault();

            var toappend = $(this).closest('.wrapper').find('.inner-wrapper');

            $(toappend).append(`
                    <div class="append">
                    <div class="row">
                        <div class="col-md-11">
                            <label for="">Question:</label>
                            <input type="text" name="question[]" class="form-control" required>
                        </div>
                        <div class="col-md-1"><a href="" class="btn btn-sm btn-danger closebtn"><i class="fa fa-minus"></i></a></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Option A</label>
                            <input type="text" name="option_a[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="">Option B</label>
                            <input type="text" name="option_b[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="">Option C</label>
                            <input type="text" name="option_c[]" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="">Option D</label>
                            <input type="text" name="option_d[]" class="form-control" required>
                        </div>
                    </div>
                    <label for="" class="mt-2">Correct Answer</label>
                    <select class="form-control col-md-6" name="correct_option[]" required>
                        <option value="a">Option A</option>
                        <option value="b">Option B</option>
                        <option value="c">Option C</option>
                        <option value="d">Option D</option>
                    </select>
                    <label for="" class="mt-2">Explanation</label>
                    <textarea name="explanation[]" rows="4" class="col-md-8 form-control"></textarea>
                </div>
                `);

            $('.closebtn').click(function(e){

                e.preventDefault();

                $(this).closest('.append').remove();

            });

        });

        

    </script>

    <script>
         CKEDITOR.replace( 'editor1' );
    </script>

</body>
</html>
