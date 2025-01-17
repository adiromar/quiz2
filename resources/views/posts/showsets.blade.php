@extends('layouts.main')

@section('styles')

<style>
.para p{
    line-height: 25px;
}    
.innerpara .qst_lbl{
    color: maroon;
}
</style>


@endsection

@section('content')

<div class="breadcrumb"><a href="{{ url('/') }}">Home</a><span class="sp-angle">»</span>
</div>

<h4 class="col-md-12 mt-3">{{ $set->setname }}</h4>

<div class="col-md-12 mt-1">
	<div class="row box_wrap">

    <?php	
        $pg = $page - 1;	
        $ng = $page + 1;
        $k=1; 
        $ii=1;$counter = 1; $starter = 1;
    ?>
    
    @foreach ( $ids[ $pg ] as $id )
    
        <?php $pos = App\Posts::find( $id ); ?> 

        @if ( $pos )
            <div class="col-md-12 post_div{{ $ii}} qstn_div">
            
                <label class="qst_lbl"><?= $start . '. ' ?> <span class="ques_wrap">{!! $pos->post_name !!}</span></label>
					
                    @if( $pos->featured )
                            <img src="{{ asset( $pos->featured ) }}" alt="No image" width="200" height="200">
                    @endif
            	    <p><a data-id="a" data-value="{{ $pos->option_a }}" data-correct="{{ strtolower($pos->correct_option) }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">

                        <?php if ( strpos( $pos->option_a , 'uploads/answers/') === false ): ?>
                            A. {{ $pos->option_a}}
                        <?php else: ?>
                            A. <img src="{{ asset( $pos->option_a ) }}" alt="" width="100" height="100">
                        <?php endif ?>

                        </a> 
                        <span class="span" style="display:none">
                            <i class="fa fa-check-circle" style="color: #13f213;"></i>
                        </span>
                    </p>

            	    <p><a data-id="b" data-value="{{ $pos->option_b }}" data-correct="{{ strtolower($pos->correct_option)  }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">

                        <?php if ( strpos( $pos->option_b , 'uploads/answers/') === false ): ?>
                            B. {{ $pos->option_b}}
                        <?php else: ?>

                            B. <img src="{{ asset( $pos->option_b ) }}" alt="" width="100" height="100">

                        <?php endif ?>

                        </a>
                    </p>

                    <p><a data-id="c" data-value="{{ $pos->option_c }}" data-correct="{{ strtolower($pos->correct_option)  }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">

                        <?php if ( strpos( $pos->option_c , 'uploads/answers/') === false ): ?>
                            C. {{ $pos->option_c}}
                        <?php else: ?>

                            C. <img src="{{ asset( $pos->option_c ) }}" alt="" width="100" height="100">

                        <?php endif ?>

                        </a>
                    </p>

                    <p><a data-id="d" data-value="{{ $pos->option_d }}" data-correct="{{ strtolower($pos->correct_option)  }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">

                        <?php if ( strpos( $pos->option_d , 'uploads/answers/') === false ): ?>
                            D. {{ $pos->option_d}}
                        <?php else: ?>

                            D. <img src="{{ asset( $pos->option_d ) }}" alt="" width="100" height="100">

                        <?php endif ?>

                        </a>
                    </p>
                
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

            <?php $starter++;$ii++;$counter++; ?>
        
        @else

        {{-- Then Its comprehensive questions --}}
        @if ( strpos( $id , "para") !== false )

        @php
        
            $thisid = explode( '_', $id );

            $paragraph = App\Paragraph::find( $thisid[1] );

        @endphp

        <div class="col-md-12 qstn_div">
        
            <label class="qst_lbl"><?= $start . '. ' ?> <span class="ques_wrap">{{ $paragraph->title }}</span></label>
            
            <div class="para">
                {!! $paragraph->paragraph !!}
            </div>

            {{-- Now get related questions and display --}}
            @php

                $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K']; 

                $subposts = $paragraph->posts;

                $pid = 0;
            @endphp

            @foreach( $subposts as $sub )
            
            <label class="qst_lbl"><?= $letters[$pid] . '. ' ?> <span class="ques_wrap">{!! $sub->post_name !!}</span></label>
            
            <p>
                <a data-id="a" data-value="{{ $sub->option_a }}" data-correct="{{ strtolower($sub->correct_option) }}" 
                    href="javascript:void()" class="option_color options_clk">
                    A. {{ $sub->option_a }}
                </a>
            </p>

            <p>
                <a data-id="b" data-value="{{ $sub->option_b }}" data-correct="{{ strtolower($sub->correct_option) }}" 
                    href="javascript:void()" class="option_color options_clk">
                    B. {{ $sub->option_b }}
                </a>
            </p>

            <p>
                <a data-id="c" data-value="{{ $sub->option_c }}" data-correct="{{ strtolower($sub->correct_option) }}" 
                    href="javascript:void()" class="option_color options_clk">
                    C. {{ $sub->option_c }}
                </a>
            </p>

            <p>
                <a data-id="d" data-value="{{ $sub->option_d }}" data-correct="{{ strtolower($sub->correct_option) }}" 
                    href="javascript:void()" class="option_color options_clk">
                    D. {{ $sub->option_d }}
                </a>
            </p>
            
            <div class="collapse" id="collapseExample{{ $k }}">
                    <div class="card card-body">
                        <?php $cor_value = str_replace('_', ' ', $sub->correct_option);
                                $cor_value = ucwords($cor_value);
                        ?>
                        <p><span class="corr_ans explain">Answer: </span>Option {{ $cor_value }}</p>
                        <p><b class="explain">Explanation: </b>{{ $sub->explanation }}</p>
                    </div>
                </div>

            <div class="collapse" id="report_{{ $k }}">
                    <div class="card card-body">
                        <form method="post" action="{{ action('PostsController@report_post', $sub->id) }}">
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

                            <input type="hidden" name="post_name" value="{{ $sub->post_name }}">
                            <input type="hidden" name="post_id" value="{{ $sub->id }}">
                            <input type="hidden" name="cat_name" value="{{ $sub->category_name }}">
                            <input type="submit" name="submit" value="Report" class="mt-2 btn btn-primary">
                        </form>
                    </div>
                </div>
            
                <a class="view_answer_color" data-toggle="collapse" href="#collapseExample{{ $k }}" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-book"></i> View Answer</a>

                <a class="ml-4 view_answer_color" data-toggle="collapse" href="#report_{{ $k }}" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-exclamation-circle"></i> Report</a>
                <br><br>
            @php $pid++; $k++; @endphp
            @endforeach
            
        </div>

        @endif

        @endif

        @php $start++; @endphp

    @endforeach

	</div>
	<ul class="pagination">
        
        <?php if ( $start > 5 ): ?>
        	<li><a href="{{ route('set.view', [$set->slug, $pg]) }}" rel="prev">« Previous</a></li>
        <?php endif ?>

        <?php if ( $start > ($page * 5) ): ?>
            <li><a href="{{ route('set.view', [$set->slug, $ng]) }}" rel="next">Next »</a></li>
        <?php endif ?>
            
        
	</ul>

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


  });

});
</script>

@endsection
