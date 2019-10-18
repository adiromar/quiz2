@extends('layouts.main')

@yield('styles')
<style media="screen" type="text/css">

</style>
@section('content')


<div class="breadcrumb">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<a href="{{ url('/') }}">Home</a><span class="sp-angle">»</span>
			  <span class="sp-angle"></span><span id="idTimerLCD"></span>
			</div>
			<div class="col-md-6">
				Your Level:
				&nbsp; {{ Auth::user()->level }}
			</div>

		</div>
	</div>

	</div>
  <div id="divResultStatistics1"></div>
	<div id="divResultStatistics" style="display: none;margin: 20px 0px;">
		<table class="table table-bordered result-statss" cellpadding="4" cellspacing="0" width="100%">
			<tbody>
				<tr>
          <td align="center" bgcolor="#ddf8c2" colspan="3"><b>Marks Obtained: [XX/XX]</b></td>
        {{-- <td>Percentage: [PTG] %</td> --}}
        <tr>
          <td>Total number of Questions</td>
          <td width="1%">:</td>
          <td width="10%" nowrap="nowrap" align="left">[TQ]</td>
        </tr>
				<tr>
          <td>No of Answered Questions</td>
          <td width="1%">:</td>
          <td width="10%" nowrap="nowrap" align="left">[AQ]</td>
				<tr>
          <td>No of UnAnswered Questions </td>
          <td width="1%">:</td>
          <td width="10%" nowrap="nowrap" align="left">[UQ]</td>
        </tr>
        <tr style="background-color: #9ebedb;">
          <td>Total Percentage</td>
          <td width="1%">:</td>
          <td width="10%" nowrap="nowrap" align="left">[PTG] %</td>
        </tr>
			</tbody>
		</table>
	</div>

@if(count($postss) > 0)
	<div class="div-test-initiator mt-4" id="divInitiator" style="border:1px solid grey;padding: 20px 30px">
             {{-- <div id="divLoading" align="center">
                <br /><img src="/_files/images/website/progress.gif" alt="Loading..." /><span class="mx-gray">&nbsp; Loading Test...</span>
             </div> --}}
             <div class="mx-none" id="divStartTestInstruction">
                <div class="div-test-instruction">
            <p class="mx-green mx-bold mx-uline"><strong>Note:</strong></p>
            <ul class="ul-test-instruction">
            <li>Total number of questions : <b>{{ count($postss) }}</b>.</li>
            <li>Time allotted : <b>10</b> minutes.</li>
            <li>Each question carry 1 mark, no negative marks.</li>
            <li>DO NOT refresh the page.</li>
            <li>All the best :-).</li>
            </ul>
         </div>
              <p align="center"><input type="button" value="Start Test" id="btnStartTest" class="btn btn-success btn-sm"/></p>
             </div>
    </div>


    <div id="divTabContent" style="display: none;margin-top: 20px;margin-bottom: 25px;">
    	<div class="container">
    		@php $k=1; @endphp

    			@foreach($postss as $pos)

          <!-- Check count -->
          <?php if ( $k > 0 ): ?>


          <div class="qst-container mb-5">

          <h5>{{ $k . '. ' . $pos->post_name }}</h5>

            <li><label class="jq-qno-{{ $pos->id }}"><input class="result-option" type="radio" data-qst="{{ $k }}" name="opt_{{ $pos->id }}" value="A" id="optionAns_A_{{ $pos->id}}"> A. {{ $pos->option_a }}</label></li>

              <li><label class="jq-qno-{{ $pos->id }}"><input class="result-option" type="radio" data-qst="{{ $k }}" name="opt_{{ $pos->id }}" value="B" id="optionAns_B_{{ $pos->id}}"> B. {{ $pos->option_b }}</label></li>

              <li><label class="jq-qno-{{ $pos->id }}"><input class="result-option" type="radio" data-qst="{{ $k }}" name="opt_{{ $pos->id }}" value="C" id="optionAns_C_{{ $pos->id}}"> C. {{ $pos->option_c }}</label></li>

              <li><label class="jq-qno-{{ $pos->id }}"><input class="result-option" type="radio" data-qst="{{ $k }}" name="opt_{{ $pos->id }}" value="D" id="optionAns_D_{{ $pos->id}}"> D. {{ $pos->option_d }}</label></li>

    		<input type="hidden" class="jq-actual-answer" id="optionAnswer_{{ $pos->id }}" value="B">
    		<input type="hidden" class="jq-selected-answer" id="optionSelAns_{{ $pos->id }}" value="">

        <div class="bix-div-answer mx-none" id="divAnswer_{{ $pos->id}}" style="display: none;">
         <div class="div-ans-des-wrapper">
            <p><span class="ib-green">Your Answer:</span> Option <span class="jq-user-answer ib-gray ib-bold"> <b>(Not Answered)</b></span></p>
            <p><span class="ib-green">Correct Answer:</span> Option <span class="ib-dgray ib-bold">{{ ucwords($pos->correct_option) }}</span></p>
           </div>  <br />
        </div>

    		@php $k++; @endphp
        <hr class="line-hr">
      </div>

        <?php endif ?>
    		@endforeach



    	</div>

      <div id="divSubmitTest" style="display: none;margin-bottom: 40px;">
      <input type="button" value="Submit" id="btnSubmitTest" class="btn btn-primary btn-sm offset-5">
      </div>
    </div>
@else


  <div class="col-md-12 mt-5">
      <p>No Questions Available.</p>
  </div>
@endif


    <div id="divResult" class="">
            {{-- <b>Submit your test now to view the Results and Statistics with answer explanation.</b> --}}
    </div>



<div id="snackbar" class="float-right"></div>

	      <input type="hidden" id="hdnTestTitleID"   value="9" />
        <input type="hidden" id="hdnTestID"        value="1009" />
        <input type="hidden" id="hdnInitialTimer"  value="600" />
        <input type="hidden" id="hdnTimer"         value="600" />


{{-- <script src="http://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script> --}}
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf-8">

	$('#btnStartTest').click(   function(){

    GeneralTestPageSpecificLoad();
  });

var _timerHandler = 0;
var _txtTestStats = ''; /* Result Stats append with feedback text */

function GeneralTestPageSpecificLoad()
{
    $(".result-option").click(  function(){  OptionClickHandler(this);           });

    // $("a.jq-menu").click(       function(){  TestTabMenuClickHandler(this);      });

    // $('#btnStartTest').click(   function(){  StartTestButtonClickHandler(this);  });
    $('#divInitiator').hide();
    $('#divTabContent').show();
    StartTestButtonClickHandler(this);
    $('#btnSubmitTest').click(  function(){ SubmitTestButtonClickHandler(this);
  });

    // InitializeTestPage();
}


function InitializeTestPage()
{
    LoadOtherPageSpecificFunctions();
    $('#divTabContent').hide();                    /* Initially hides the Test questions, Shows 'Start Test' button.*/
    $('#btnSubmitTest').attr('disabled', 'disabled');
}

function LoadOtherPageSpecificFunctions()
{
    /* Invoke : Other Page Specific Functions  */
    var txtTestTitleID  = $('#hdnTestTitleID').val();
    if( txtTestTitleID == '2'  ||  /* C    */
        txtTestTitleID == '13' ||  /* Java */
        txtTestTitleID == '30' ||  /* C#   */
        txtTestTitleID == '37'     /* CPP  */
        )
    StartCodeHighlight();
}

 $(function(){
  var num = 1;
  // $('input:radio[data-qst='+num+']').change(function() {
  $('input[type="radio"]').change(function(){
    if ($(this).is(':checked'))
    {
      // console.log($(this).val());
      // $($(this).val()).appendTo('.jq-selected-answer');
      $(this).closest('.qst-container').find('.jq-selected-answer').val($(this).val());
    }
    num++;
  });
});


function SubmitTestButtonClickHandler(thisObj)
{
  // console.log(thisObj);

    console.log("submit test button click handler");

    var txtMsg = '';
    var intUAC = $("input.jq-selected-answer[value='']").length;
    if( intUAC > 0) txtMsg = "Total number of unanswered questions = " + intUAC + ".\n\n" ;
    // console.log(intUAC);
    if(confirm(txtMsg + 'Are you sure you want to submit the Test now?'))  /* Check for Time limit also. */
    {
        // OptionClickHandler(thisObj);
        $(thisObj).attr('disabled', 'disabled');
        PopulateResultStatics();
        // save_data();
    }
}

function StartTestButtonClickHandler(thisObj)
{
    /* 4 Lines - Firefox Combatability */
    // alert("clicked this");
    $('#divResult').html('');
    $('.result-option').removeAttr('disabled');
    $('.result-option').removeAttr('checked');
    $('#hdnTimer').val( $('#hdnInitialTimer').val() );

    $('#divInitiator').remove();
    $('#btnSubmitTest').removeAttr('disabled'); $('#divSubmitTest').show();
    $('#divTabContent').show();
    $('#idTimerSpan').show();
    $('#divFloatTimer').show();
    _timerHandler = setInterval( "MyTimer()" , 1000);
}

function OptionClickHandler(thisObj)
{
    // console.log("option click handler");
     var objID = thisObj.id;               //option_A_25     1 - A ; 2 - 25
     var optAns = objID.split('_')[1];
     var quesID = objID.split('_')[2];
     var preVal = $("#optionSelAns_" + quesID).val();

     if(preVal == "")
     {
       $("#optionSelAns_" + quesID).val( optAns );     // set current option as answer.
       $(thisObj).attr("checked" , "checked");
       $('.jq-qno-' + quesID).addClass('ib-answered');
     }
     else if(preVal == optAns)
     {
        $("#optionSelAns_" + quesID).val("");
        $(thisObj).removeAttr("checked");              //remove cur. object option check mark.
        $(this).closest('.qst-container').find('label').addClass('tru_color');
        document.getElementById("optionSelAns_" + quesID).style.background = "blue";
        // $('.qst-container li label').addClass('tru_color');
        $('.jq-qno-' + quesID).removeClass('ib-answered');
     }
     else
     {
        $("#optionSelAns_" + quesID).val( optAns );
        $(".cls_" + quesID).removeAttr("checked");  // remove all check mark
        $(thisObj).attr("checked" , "checked");        // set check mark to current one.
        $('.jq-qno-' + quesID).addClass('ib-answered');
     }
}

function MyTimer()
{
   var valueTimer = $('#hdnTimer').val();

   if(valueTimer > 0)
   {
       valueTimer = valueTimer - 1;

       hours = (valueTimer/3600).toString().split('.')[0];
       mins  = ((valueTimer % 3600) / 60).toString().split('.')[0];
       secs  = ((valueTimer % 3600) % 60).toString();

       if(hours.length == 1) hours = '0' + hours;
       if(mins.length  == 1) mins  = '0' + mins;
       if(secs.length  == 1) secs  = '0' + secs;

       $('#idTimerLCD').text( hours + ':' +  mins + ':'  + secs);
       $('#hdnTimer').val( valueTimer );

       document.title = $('#idTimerLCD').text();
       var snack = document.getElementById("snackbar");
       snack.className = "show";
       $('#snackbar').text( "Time Remaining: " + $('#idTimerLCD').text() );
   }
   else
   {
       $('#btnSubmitTest').attr('disabled', 'disabled');
       alert(" Your time is up ! \n\n Let's see the Result & Statistics of the Test.");
       PopulateResultStatics();
   }
}

function PopulateResultStatics()
{
    clearInterval(_timerHandler);
    $('#idTimerSpan').hide();
    $('#divFloatTimer').hide();
    $('#snackbar').hide();
    document.title = 'Test Result';
    $('.result-option').attr('disabled' , 'disabled');
    $('.result-option').css('cursor' , 'auto');
    $('#divResult').show();

    /* Populate result tab.   */
    var txtHtml               = $('#divTabContent').html();
    var objArrActualAnswer    = $('#divTabContent input.jq-actual-answer');
    var objArrSelectedAnswer  = $('#divTabContent input.jq-selected-answer');

    $('#divTabContent').remove();
    $('#divSubmitTest').remove();

    $('#divResult').html(txtHtml);
    $('#divResult .jq-workspace').remove();

    var intTotalQuestions     = objArrActualAnswer.length;
    var intAnsweredCount      = 0;
    var intUnAnsweredCount    = 0;
    var intCorrectAnswerCount = 0;
    var intWrongAnswerCount   = 0;
    var percentage            = 0;
    var objArrUserAnswer      = $('#divResult span.jq-user-answer');

    /* Iteration for All Ques Answers - Populates Result Info. */
    jQuery.each(objArrActualAnswer, function(i, obj)
    {

        var optionActual   = $(obj).val();
        var optionSelected = $(objArrSelectedAnswer[i]).val();
        var quesID         = obj.id.split('_')[1];              // optionAnswer_45 (hidden)

        if(optionSelected != '')
        {
            //Radio Option ID :  optionAns_C_741
            $('#divResult #optionAns_' + optionSelected + '_' + quesID).attr('checked', 'checked');
            $('#divResult #tdAnswerIMG_' + optionSelected + '_' + quesID).show();
            intAnsweredCount++;
            if(optionSelected == optionActual){
              $(optionActual).addClass('ib-answeredd');
              intCorrectAnswerCount++;
            } else{
              intWrongAnswerCount++;
            }

            /* To display value for "Your answer:" */
            $(objArrUserAnswer[i]).html(optionSelected);
        }



    });

    intUnAnsweredCount = intTotalQuestions -  intAnsweredCount;

    /* Sets results Statistics info.  */
    var tmpResStat = $('#divResultStatistics').html();
    tmpResStat = tmpResStat.replace('[XX/XX]' , intCorrectAnswerCount + '/' + intTotalQuestions);
    // percentage = (intCorrectAnswerCount / intTotalQuestions) * 100;
    percentage = Math.round((intCorrectAnswerCount / intTotalQuestions) * 100);

    var level = {{ Auth::user()->level }};

		//AJAX
		$.ajaxSetup({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
					}
			});

    if ( percentage >= 85 ) {

      var userid = {{ Auth::id() }};

      $.get("{{ url('/update/user/level') }}", { percentage, userid },
        function(response){

          console.log(response);

        });

        $('#divResultStatistics1').empty();
        $('#divResultStatistics1').append(`

            <h5 style="color: maroon;font-weight:600;padding-top: 15px;">
              Congratulations! You have completed a Level. You can take another quiz for more level of questions.
            </h5>

        `);

    }

    tmpResStat = tmpResStat.replace('[PTG]'    , percentage);
    tmpResStat = tmpResStat.replace('[TQ]'    , intTotalQuestions);
    tmpResStat = tmpResStat.replace('[AQ]'    , intAnsweredCount);
    tmpResStat = tmpResStat.replace('[UQ]'    , intUnAnsweredCount);
    $('#divResultStatistics').html(tmpResStat);

    $('#divResult .bix-div-answer').show();        /* Makes visible all AnsDesc. divs.  */

    /* Initial Swap to Result Stat. Tab */
    $('#divResult').show();  $('#divResultStatistics').show();

    window.scroll(0,0); /* Scrolls up the window. */

    // AddGeneralTestViewCount(); /* Ajax call to server. */

    var totalTime = parseInt($('#hdnInitialTimer').val())/60;

    var timeTaken = (totalTime*60) - parseInt($('#hdnTimer').val());

    _txtTestStats  =    " [ TotQ="   + intTotalQuestions      +
                        ", AnsQ="     + intAnsweredCount       +
                        ", UnAnsQ="   + intUnAnsweredCount     +
                        ", CorAns="   + intCorrectAnswerCount  +
                        ", WrongAns=" + intWrongAnswerCount    +
                        ", TotTime="     + totalTime   +
                        "min, TimeTaken="     + timeTaken +"sec]"  ;

		// Insert into ranking table using ajax
		$.get( "{{ url('/update/userranking') }}" , { intTotalQuestions,intCorrectAnswerCount,timeTaken },
			function(response){	}
		);
}
</script>
@endsection
