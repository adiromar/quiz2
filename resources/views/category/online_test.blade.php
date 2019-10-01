@extends('layouts.main')
@section('styles')
<style media="screen" type="text/css">
.corr_ans{color: green;font-weight: 700;}
.wro_ans{color: red;font-weight: 700;}
.v-color{
color: #9f9797  !important;
opacity: 0.8;
/*background-color: lightgrey !important;*/
}
.v-color a{
color: red !important;
background-color: lightgrey !important;
}
.tru_color{
color: black !important;
background-color: lightgreen !important;
}
#clockdiv{
background-color: aliceblue;
font-size: 18px;
font-weight: 700;
color: #e94e4e;
padding: 5px;
}
</style>
@endsection
@section('content')
@php

$name = ucfirst($categoryy->category_name);
$ch_slug = str_replace(' ', '-', $categoryy->category_name);
$c_slug = strtolower($ch_slug);
@endphp
<div class="breadcrumb"><a href="{{ url('/') }}">Home</a><span class="sp-angle">»</span><a href="{{ url('cat/'.$ch_slug.'/'.$categoryy->id.'') }}">{{ $name }}</a><span class="sp-angle">»</span><a href="#">Online Test</a></div>
<div class="col-md-12" id="test_id">
  <h4>Online test</h4>
  <div class="card">
    <p class="test_instructions_head">Instructions: </p>
    <ul>
      <li>Total no of Questions: 20</li>
      <li>Time Allotted: 10 mins</li>
      <li>Each question carry 1 mark, no negative marks.</li>
      <li>DO NOT refresh the page.</li>
    </ul>
    
    <div class="col-md-3">
      <input type="button" value="Start Test" id="btnStartTest" class="btn btn-secondary">
    </div>
  </div>
</div>
{{-- <form id="test_form" action="{{ action('CategoryController@validate_test', $categoryy->id) }}" method="post"> --}}
  {{-- <input name="_token" type="hidden" value="{{ csrf_token() }}"/> --}}
  <div class="row tbl_results mt-4" style="display: none;">
    <table class="table table-striped">
      <thead>
        <tr style="background-color: #ccd7fa">
          <th>Marks: </th><th></th><th></th>
        </tr>
      </thead>
      <tr>
        <td>Total No. of Questions: <b>20</b></td>
        <td>Number of Answered Questions: <b>-</b></td>
        <td>Number of Unanswered Questions: <b>-</b></td>
      </tr>
    </table>
  </div>
  <div class="row mt-5" id="show_this_div" style="display: none;margin-bottom: 25px;">
    <div id="clockdiv" class="offset-5"></div>
    
    @if(count($postss) > 0)
    @php
    $cat_name = mb_convert_case($postss[0]->category_name, MB_CASE_TITLE);
    @endphp
    <h4 class="col-md-12">{{ $cat_name }}</h4>
    @php $k=1;$ii=1; @endphp
    @foreach($postss as $pos)
    @php
    $correct_ans = $pos->correct_option;
    $correct_ans = str_replace('_', ' ', $correct_ans);
    $cor_ans = ucwords($correct_ans);
    @endphp
    <div class="col-md-12 box_shade post_div{{ $ii}}">
      
      <p><span>{{ $k }}. </span>{{ $pos->post_name }}</p>
      <p><label><input type="checkbox" class="radio" value="{{ $pos->option_a }}" name="option{{ $k }}" id="option_a{{ $k }}" data-grp="option_a"> {{ $pos->option_a }}</label></p>
      <p><label><input type="checkbox" class="radio" value="{{ $pos->option_b }}" name="option{{ $k }}" id="option_b{{ $k }}" data-grp="option_b"> {{ $pos->option_b }}</label></p>
      <p><label><input type="checkbox" class="radio" value="{{ $pos->option_c }}" name="option{{ $k }}" id="option_c{{ $k }}" data-grp="option_c"> {{ $pos->option_c }}</label></p>
      <p><label><input type="checkbox" class="radio" value="{{ $pos->option_d }}" name="option{{ $k }}" id="option_d{{ $k }}" data-grp="option_d"> {{ $pos->option_d }}</label></p>
      @php
      if ($pos->correct_option == $pos->option_a){
      $val = $pos->option_a;
      }else if($pos->correct_option == $pos->option_b){
      $val = $pos->option_b;
      }else if($pos->correct_option == $pos->option_c){
      $val = $pos->option_c;
      }else{
      $val = $pos->option_d;
      }
      @endphp
      {{-- <input type="text" name="correct_answer" value="{{ $pos->correct_option }}"> --}}
      <p class="your_ans"></p>
      {{-- <p class="ys">Your Answer: </p> --}}
      {{-- <table class="" cellspacing="0" cellpadding="0" border="0" width="100%">
        <tbody>
          <tr>
            <td rowspan="2" valign="top" align="left">{{ $k }}<span>. </span></td>
            <td valign="top">{{ $pos->post_name }}</td>
          </tr>
          <tr>
            <td valign="top">
              
              <table class="tbl_opt" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td nowrap="nowrap" width="2%"><input type="checkbox" class="radio" id="option_ans{{ $k }}"  value="{{ $pos->option_a }}" name="opt {{ $k }}"></td>
                    <td width="98%">
                      <table>
                        <tbody>
                          <tr>
                            <td>{{ $pos->option_a }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
              <table class="tbl_opt" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td nowrap="nowrap" width="2%"><input type="checkbox" class="radio" id="option_ans{{ $k }}" value="{{ $pos->option_b }}" name="opt {{ $k }}"></td>
                    <td width="98%">
                      <table>
                        <tbody>
                          <tr>
                            <td>{{ $pos->option_b }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
              <table class="tbl_opt" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td nowrap="nowrap" width="2%"><input type="checkbox" class="radio" id="option_ans{{ $k }}" value="{{ $pos->option_c }}" name="opt {{ $k }}"></td>
                    <td width="98%">
                      <table>
                        <tbody>
                          <tr>
                            <td>{{ $pos->option_c }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
              <table class="tbl_opt" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td nowrap="nowrap" width="2%"><input type="checkbox" class="radio" id="option_ans{{ $k }}" value="{{ $pos->option_d }}" name="opt {{ $k }}"></td>
                    <td class="your_anss"></td>
                    <td width="98%">
                      <table>
                        <tbody>
                          <tr>
                            <td>{{ $pos->option_d }}</td>
                          </tr>
                        </tbody>
                      </table>
                    </td>
                  </tr>
                </tbody>
              </table>
            </td>
          </tr>
        </tbody>
      </table> --}}
      
      <div class="collapse" id="collapseTestExample{{ $k }}">
        <div class="card card-body col-back">
          <?php $cor_value = str_replace('_', ' ', $pos->correct_option);
          $cor_value = ucwords($cor_value);
          ?>
          <p><span class="your_ans">Your Answer: </span></p>
          <p><span class="corr_ans">Answer: </span>{{ $cor_value }}</p>
          
        </div>
      </div>
      
    </div>
    <?php $k++;$ii++; ?>
    @endforeach
    <input type="button" value="Submit" id="sbt_btn" class="btn btn-primary offset-5" onclick="showInput();">
    {{-- <input type="text" name="qst_count" value="{{ $k-1 }}"> --}}
    {{-- onclick="showInput();" --}}
    @else
    <h4>No Questions to Show</h4>
    @endif
  </div>
{{-- </form> --}}
</div>
</div>
<div class="row">
{{-- <button onclick="myFunction()">Show Snackbar</button> --}}
<div id="snackbar" class="float-right">Time Remaining: </div>
</div>
<script src="http://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready( function(){
// $('.options_clk').on('click', function (e){
//   e.preventDefault();
//   // var selectedOptions = $('select[data="id"] option:selected');
//   // var selectedOptions = $(this).find(':selected');
//   var id = $(this).attr('id')
//   var options = $(this).data('id');
//   var correct = $(this).data('correct');
//   // alert(id);
//   if (options == correct){
//       $(this).addClass('tru_color');
//       $('.show_correct'+id+'').show();
//       // $('.wrong'+id+'').hide();
//       $(this).removeClass('option_color');
//   }else{
//       // alert("incorrect");
//       // document.getElementByClassName.style.backgroundColor = "transparent";
//       // document.getElementsByClassName('wrong'+id+'').style.color = "red";
//       // $(this).css('background-color', 'red');
//        $(this).addClass('v-color');
//        $(this).removeClass('option_color');
//       $('.show_correct'+id+'').hide();
//       // $('.wrong'+id+'').show();
//   }


//   console.log(correct);
// });
$("input:checkbox").on('click', function() {
var $box = $(this);
var $val = $(this).val();
if ($box.is(":checked")) {
console.log($box);

var group = "input:checkbox[name='" + $box.attr("name") + "']";

$(group).prop("checked", false);
$box.prop("checked", true);
} else {
$box.prop("checked", false);
}
});
// online test
$('#btnStartTest').on('click', function (e){

  // alert("button clicked");
  $('#test_id').hide();
  $('#show_this_div').show('slow');
  // 10 minutes from now
  var time_in_minutes = 10;
  var current_time = Date.parse(new Date());
  var deadline = new Date(current_time + time_in_minutes*60*1000);
  var dl = new Date(time_in_minutes*60*1000);
  function time_remaining(endtime){
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor( (t/1000) % 60 );
  var minutes = Math.floor( (t/1000/60) % 60 );
  var hours = Math.floor( (t/(1000*60*60)) % 24 );
  var days = Math.floor( t/(1000*60*60*24) );
  return {'total':t, 'days':days, 'hours':hours, 'minutes':minutes, 'seconds':seconds};
  }
  function run_clock(id,endtime){
  var clock = document.getElementById(id);
  function update_clock(){
  var t = time_remaining(endtime);
  clock.innerHTML = 'Time Remaining: 00:'+t.minutes+':'+t.seconds;
  // console.log(clock.innerHTML);
  if(t.total<=0){
  // console.log('time elaspsed');
  document.getElementById('sbt_btn').click();
  clearInterval(timeinterval);

  }
  }
  update_clock(); // run function once at first to avoid delay
  var timeinterval = setInterval(update_clock,1000);
  }
  run_clock('clockdiv',deadline);
  run_clock('snackbar',deadline);
  // run_clock('snackbar1',deadline);
  // run clock on snackbar
  // document.getElementById("snackbar").click();
  var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, dl);
  // validate test

});
});
function showInput(){
  
  // alert('form submitted');
  if ( confirm("Confirm Submit Form ?") ) {
    
    $(window).scrollTop(0);
    $('#clockdiv').hide();
    $('#snackbar').hide();
    // $('.collapse').addClass('show');
    $('.tbl_results').show();

  }

}
</script>
@endsection