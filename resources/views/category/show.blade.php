@extends('layouts.main')

@yield('styles')

<style media="screen" type="text/css">
    .explain{
        color: blue;
    }
</style>

@section('content')

@php
    $cmain = mb_convert_case($main, MB_CASE_TITLE);
    $cname = mb_convert_case($slug, MB_CASE_TITLE);
@endphp
<div class="breadcrumb"><a href="{{ url('/') }}">Home</a><span class="sp-angle">»</span>
    <a href="{{ url(''.$main.'/'.$categoryy->main_category_id.'') }}">{{ $main }}</a><span class="sp-angle">»</span>
    <a href="{{ url(''.$main.'/'.$slug.'/'.$categoryy->id.'') }}">{{ $slug }}</a>
    <span class="sp-angle">»</span></div>

@if(count($postss) > 0)
    
    <div class="col-md-12" >
        <div class="row mt-5">
            @php
                $name = ucfirst($postss[0]->category_name);
                $ch_slug = str_replace(' ', '-', $postss[0]->category_name);
                $c_slug = strtolower($ch_slug);
            @endphp
            
        {{-- <div class="col-md-12 mb-4" style="border: 1px solid lightgrey;">
            <h5 class="">Take Online Test</h5>
            <div class="col-md-6 mb-3">
                <p>Questions: 20</p>
                
                <a href="{{ url('online-test/'.$c_slug.'/'.$postss[0]->category_id.' ') }}" class="btn btn-primary mb-1">Take Online Test</a>
                <a href="{{ url('test/online-quiz/'.$c_slug.'/'.$postss[0]->category_id.' ') }}" class="btn btn-secondary mb-1">Online Quiz</a>
            </div>
        </div> --}}

        @php
            $cat_name = mb_convert_case($postss[0]->category_name, MB_CASE_TITLE);

        @endphp
            <h4 class="col-md-12">{{ $cat_name }}</h4>

    <?php 
  $pg = 0;
  if(isset($_GET['page'])){
    $page = $_GET['page'];
    $pg = $page * $pg;
  }
    $k=1+$pg;$ii=1; ?>
	@foreach($postss as $pos)
            <div class="col-md-12 post_div{{ $ii}} qstn_div">
            	<label class="qst_lbl"><?= $k . '. ' ?> {{ $pos->post_name }}</label>
            	<p><a data-id="a" data-value="{{ $pos->option_a }}" data-correct="{{ $pos->correct_option  }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">A. {{ $pos->option_a}}</a> <span class="span" style="display:none"><i class="fa fa-check-circle" style="color: #13f213;"></i></span></p>

            	<p><a data-id="b" data-value="{{ $pos->option_b }}" data-correct="{{ $pos->correct_option  }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">B. {{ $pos->option_b}}</a></p>

                <p><a data-id="c" data-value="{{ $pos->option_c }}" data-correct="{{ $pos->correct_option  }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">C. {{ $pos->option_c}}</a></p>

                <p><a data-id="d" data-value="{{ $pos->option_d }}" data-correct="{{ $pos->correct_option  }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">D. {{ $pos->option_d}}</a></p>

                {{-- <p class="correct_val" style="display: none;">{{ $pos->correct_option }}</p> --}}
            	{{-- <p class="show_correct{{ $k }}" style="display: none;color: green;">Correct Answer: <i class="fa fa-check-circle" style="color: #13f213;"></i></p> --}}
                {{-- <p class="wrong{{ $k }}" style="display: none;"><i class="fa fa-times-circle" style="color: red;"></i></p> --}}
                
                <div class="collapse" id="collapseExample{{ $k }}">
                    <div class="card card-body">
                        <?php $cor_value = str_replace('_', ' ', $pos->correct_option); 
                              $cor_value = ucwords($cor_value);
                        ?>
                        <p><span class="corr_ans explain">Answer: </span>Option {{ $cor_value }}</p>
                        <p><b class="explain">Explanation: </b>{{ $pos->explanation }}</p>
                    </div>
                </div>
                {{-- report question --}}
                <div class="collapse" id="report_{{ $k }}">
                    <div class="card card-body">
                        <form method="post" action="{{ action('PostsController@report_post', $pos->id) }}">
                            {{ csrf_field() }}
                            <h6 class="rep_post_head">Report This Question</h6>
                            <br>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="report_username">Name :</label>
                                    <input type="text" name="report_username" class="form-control" id="report_username">
                                </div>

                                <div class="col-md-3">
                                    <label for="report_email">Email :</label>
                                    <input type="email" name="report_email" class="form-control" id="report_email">
                                </div>

                                <div class="col-md-4">
                                    <label for="report_msg">Message :</label>
                                    <input type="text" name="message" class="form-control" id="report_msg">
                                </div>
                            </div>

                            <input type="hidden" name="post_name" value="{{ $pos->post_name }}">
                            <input type="hidden" name="post_id" value="{{ $pos->id }}">
                            <input type="hidden" name="cat_name" value="{{ $pos->category_name }}">
                            <input type="submit" name="submit" value="Report" class="mt-2 btn btn-primary">
                        </form>
                    </div>
                </div>

                <a class="view_answer_color" data-toggle="collapse" href="#collapseExample{{ $k }}" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-book"></i> View Answer</a>

                <a class="ml-4 view_answer_color" data-toggle="collapse" href="#report_{{ $k }}" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-exclamation-circle"></i> Report</a>
            </div>
            
<?php $k++;$ii++; ?>
    @endforeach
{{ $postss->links()}}

        @else
            <h4 class="mt-4">No Questions to Show</h4>
        @endif

        </div>
    </div>


<script src="http://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).ready( function(){

  $('.options_clk').on('click', function (e){
    e.preventDefault(); 
    
    var id = $(this).attr('id')
    var options = $(this).data('id');
    var correct = $(this).data('correct');
    // alert(options);
    if (options == correct){
        // $('.add-sq').show();
        $(this).addClass('tru_color');
        // $(this).append('add-sq');
        $( event.target ).closest( "p" ).show( "add-sq" );
        $( event.target ).closest( "p" ).toggleClass( "highlight" );
        // $(this).closest( "span" ).show();
        $('.show_correct'+id+'').show();
        // $('p').find('#span'+id+'').show();
        // $('.wrong'+id+'').hide();
        $(this).removeClass('option_color');
    }else{
        
         $(this).addClass('v-color');
         $(this).removeClass('option_color');
        $('.show_correct'+id+'').hide();
        // $('.wrong'+id+'').show();
    }
    
    
    console.log(correct);
  });

});
</script>
@endsection


