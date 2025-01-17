@extends('layouts.main')

@section('seo')

	<meta name="description" content="Quizzer Nepal | Category: {{ $main->main_category_name }}">
	<meta name="keywords=" content="quizzer,quizzer nepal,quiz nepal,nepal quiz,class,classroom, class room,video classes,category page,{{ $main->main_category_name }}">

@endsection

@section('content')
	@php
	$m_name = mb_convert_case($main->main_category_name, MB_CASE_TITLE);
	@endphp

	<div class="breadcrumb mb-4"><a href="{{ url('/') }}">Home</a><span class="sp-angle">»</span><a href="{{ url(''.$main->slug.'/'.$main->id.'') }}">{{ $m_name }}</a><span class="sp-angle">»</span>Topics List</div>

	<hr>

	<!-- <div class="col-md-9">
		<div class="row">
	
		@if(count($submain) > 0)
			@foreach($submain as $smain)
	
				@if($smain->featured == true)
				<div class="col-md-4">
					<span style="color: #e5e544"><i class="fa fa-folder"></i></span><a href="{{ route('cat', [ $main->slug, $smain->slug, $smain->id, 1 ]) }}"> {{ $smain->category_name }}{{ ' ('. $smain->posts->count() . ') -' .$smain->id }}</a>
				</div>
				@endif
				
			@endforeach
		@else
			<p>No Cateogry Lists Found</p>
		@endif
	
		</div>
	</div> -->


{{--  display posts starts  --}}

@if(count($postss) > 0)
    <div class="col-md-12" >
        <div class="row mt-5">
            @php
                $name = ucfirst($postss[0]->category_name);
                $ch_slug = str_replace(' ', '-', $postss[0]->category_name);
                $c_slug = strtolower($ch_slug);
            @endphp

        @php
            $cat_name = mb_convert_case($postss[0]->category_name, MB_CASE_TITLE);

        @endphp
            <h4 class="col-md-12">{{ $cat_name }}</h4>


@php
    if ( $page ) {
        $pg = $page - 1;
        $ng = $page + 1;
    }else{
        $pg = 0;
        $ng = 0;
    }


    $k=1;$ii=1;$counter = 1; $starter = 1;
@endphp


@foreach($postss as $pos)
	@if( $counter >= $start AND $counter <= $stop  )

	 <div class="col-md-12 post_div{{ $ii}} qstn_div">
            	<label class="qst_lbl"><?= $k . '. ' ?> <span class="ques_wrap">{!! $pos->post_name !!}</span></label>
                <br>

                @if( $pos->featured )
                    <img src="{{ asset( $pos->featured ) }}" alt="No image" width="200" height="200">
                @endif

            	<p><a data-id="a" data-value="{{ $pos->option_a }}" data-correct="{{ strtolower($pos->correct_option)  }}" id="{{ $k }}"
                href="javascript:void()" class="option_color options_clk">

                    <?php if ( strpos( $pos->option_a , 'uploads/answers/') === false ): ?>
                    A. {{ $pos->option_a}}
                    <?php else: ?>

                    A. <img src="{{ asset( $pos->option_a ) }}" alt="" width="100" height="100">

                    <?php endif ?>


                </a> <span class="span" style="display:none"><i class="fa fa-check-circle" style="color: #13f213;"></i></span></p>

            	<p><a data-id="b" data-value="{{ $pos->option_b }}" data-correct="{{ strtolower($pos->correct_option)  }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">

                    <?php if ( strpos( $pos->option_b , 'uploads/answers/') === false ): ?>
                    B. {{ $pos->option_b}}
                    <?php else: ?>

                    B. <img src="{{ asset( $pos->option_b ) }}" alt="" width="100" height="100">

                    <?php endif ?>

                </a></p>

                <p><a data-id="c" data-value="{{ $pos->option_c }}" data-correct="{{ strtolower($pos->correct_option)  }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">

                    <?php if ( strpos( $pos->option_c , 'uploads/answers/') === false ): ?>
                    C. {{ $pos->option_c}}
                    <?php else: ?>

                    C. <img src="{{ asset( $pos->option_c ) }}" alt="" width="100" height="100">

                    <?php endif ?>

                </a></p>

                <p><a data-id="d" data-value="{{ $pos->option_d }}" data-correct="{{ strtolower($pos->correct_option)  }}" id="{{ $k }}" href="javascript:void()" class="option_color options_clk">

                    <?php if ( strpos( $pos->option_d , 'uploads/answers/') === false ): ?>
                    D. {{ $pos->option_d}}
                    <?php else: ?>

                    D. <img src="{{ asset( $pos->option_d ) }}" alt="" width="100" height="100">

                    <?php endif ?>

                </a></p>

                <!-- <p class="correct_val" style="display: block;">{{ $pos->correct_option }}</p> -->
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
<?php $starter++; ?>

            @endif
	<?php $k++;$ii++; $counter++;?>
    @endforeach
        @else
            <h4 class="mt-4">No Questions to Show</h4>
        @endif
</div>

        <ul class="pagination">
        <?php if ( $pg > 0 ): ?>
            <li><a href="{{ route('m_cat', [$slug, $main, $pg]) }}" rel="prev">« Previous</a></li>
        <?php endif ?>

        <?php if( count($postss) > $stop){?>
            <li><a href="{{ route('m_cat', [$slug, $main, $ng]) }}" rel="next">Next »</a></li>
        <?php } ?>
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