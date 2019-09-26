@extends('layouts.main')

@section('content')
	@php
    // dd($categoryy);
    $cname = ucfirst($categoryy->category_name);
@endphp
<div class="breadcrumb mb-4"><a href="{{ url('/') }}">Home</a><span class="sp-angle">»</span><a href="{{ url('cat/'.$cname.'/'.$categoryy->id.'') }}">{{ $cname }}</a><span class="sp-angle">»</span>Online Quiz</div>

<div class="container mb-5">
	{{-- show results --}}
	<div id="divResultStatistics" style="display: none;"> 
		<table class="table table-bordered">
			<tbody>
				<tr><td>Marks: </td></tr>
				<tr><td>No of Answered Questions: </td></tr>
				<tr><td>No of UnAnswered Questions: </td></tr>
			</tbody>
		</table>
	</div>

	{{-- Initiate test  --}}
		<div class="div-test-initiator" id="divInitiator">

             <div class="mx-none" id="divStartTestInstruction">
                <div class="div-test-instruction">
            <p class="mx-green mx-bold mx-uline">Instruction:</p>
            <ul class="ul-test-instruction">
            <li>Total number of questions : <b>20</b>.</li>
            <li>Time alloted : <b>30</b> minutes.</li>
            <li>Each question carry 1 mark, no negative marks.</li>
            <li>DO NOT refresh the page.</li>
            <li>All the best :-).</li>
            </ul>
         </div>
              <p align="center"><i class="fa fa-clock"></i><input type="button" value="Start Test" id="btnStartTest" class="btn btn-secondary" /></p>
             </div>
    </div>

    <div id="divTabContent" style="display: none;">
    	<form action="{{ action('CategoryController@validate_test', $categoryy->id) }}" method="post">
    		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

    	<div class="container">
    		@php $k=1; @endphp
    		@if(count($postss) > 0)
    			@foreach($postss as $pos)
    			@php
    			$j = $pos->id;
    			@endphp

    			<div class="col-md-12">
    			<label>{{ $k . '. ' . $pos->post_name }}</label>
    			</div>
    			<div class="col-md-6">
    			<label><input type="radio" name="opt{{ $j }}" value="{{ $pos->option_a }}"> {{ $pos->option_a }}</label></div>

    			<div class="col-md-6">
    			<label><input type="radio" name="opt{{ $j }}" value="{{ $pos->option_b }}"> {{ $pos->option_b }}</label></div>

    			<div class="col-md-6">
    			<label><input type="radio" name="opt{{ $j }}" value="{{ $pos->option_c }}"> {{ $pos->option_c }}</label></div>

    			<div class="col-md-6">
    			<label><input type="radio" name="opt{{ $j }}" value="{{ $pos->option_d }}"> {{ $pos->option_d }}</label></div>

    			<input type="text" name="correct_option[]" value="{{ $pos->correct_option }}">
    			<input type="hidden" name="post_id[]" value="{{ $pos->id}}">
    			<hr class="line-hr">
    		@php $k++; @endphp
    		@endforeach
    		<input type="text" name="cat_id" value="{{ $categoryy->id}}">
    		<input type="submit" name="submit" value="Submit" class="btn btn-primary">
    		@endif
    	</div>
    	</form>
    </div>

</div>
<p id="idTimerLCD"></p>
	<input type="hidden" id="hdnTestTitleID"   value="9" />
        <input type="hidden" id="hdnTestID"        value="1009" />
        <input type="hidden" id="hdnInitialTimer"  value="60" />
        <input type="hidden" id="hdnTimer"         value="60" />

<script src="http://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha256-3edrmyuQ0w65f8gfBsqowzjJe2iM6n0nKciPUp8y+7E="
  crossorigin="anonymous"></script>
<script type="text/javascript">

	$('#btnStartTest').click(   function(){ 

		StartTestButtonClickHandler(this);  });

var _timerHandler = 0;
var _txtTestStats = '';

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
       $('#idFloatTimerLCD').text( $('#idTimerLCD').text() ); 
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
}

</script>

@endsection

<table class="bix-tbl-container" cellspacing="0" cellpadding="0" border="0" width="100%"><tr>
        <td class="bix-td-qno jq-qno-212"  rowspan="2" valign="top" align="left">1.</td>
         <td class="bix-td-qtxt" valign="top"><p>You want to create a standard access list that denies the subnet of the following host: 172.16.144.17/21. Which of the following would you start your list with?</p></td>
          </tr>
            <tr>
                <td class="bix-td-miscell" valign="top">
                	<table class="bix-tbl-options" id="tblOption_212" border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td nowrap="nowrap" class="bix-td-option bix-td-radio" width="1%"  id="tdOptionNo_A_212"><input type="checkbox" class="result-option cls_212" id="optionAns_A_212"></td><td class="bix-td-option" width="1%">A.</td>
                         <td class="bix-td-option" width="99%" id="tdOptionDt_A_212"><table border="0" cellpadding="0" cellspacing="0">
        <tr>                                                          
        <td class="bix-inner-td-option"><i class="networking-code">access-list 10 deny 172.16.48.0 255.255.240.0</i></td>                                                         
        <td id="tdAnswerIMG_A_212" class="jq-img-answer mx-none mx-lpad-10"  valign="middle">               
           <img src="/_files/images/website/wrong.gif" alt="" />  
        </td>                                                         
        </tr>                                                         
        </table></td></tr><tr><td nowrap="nowrap" class="bix-td-option bix-td-radio" width="1%"  id="tdOptionNo_B_212"><input type="checkbox" class="result-option cls_212" id="optionAns_B_212"></td><td class="bix-td-option" width="1%">B.</td>
                         <td class="bix-td-option" width="99%" id="tdOptionDt_B_212"><table border="0" cellpadding="0" cellspacing="0">
        <tr>                                                          
        <td class="bix-inner-td-option"><i class="networking-code">access-list 10 deny 172.16.144.0 0.0.7.255</i></td>                                                         
        <td id="tdAnswerIMG_B_212" class="jq-img-answer mx-none mx-lpad-10"  valign="middle">               
           <img src="/_files/images/website/accept.png" alt="" />  
        </td>                                                         
        </tr>                                                         
        </table></td></tr><tr><td nowrap="nowrap" class="bix-td-option bix-td-radio" width="1%"  id="tdOptionNo_C_212"><input type="checkbox" class="result-option cls_212" id="optionAns_C_212"></td><td class="bix-td-option" width="1%">C.</td>
                         <td class="bix-td-option" width="99%" id="tdOptionDt_C_212"><table border="0" cellpadding="0" cellspacing="0">
        <tr>                                                          
        <td class="bix-inner-td-option"><i class="networking-code">access-list 10 deny 172.16.64.0 0.0.31.255</i></td>                                                         
        <td id="tdAnswerIMG_C_212" class="jq-img-answer mx-none mx-lpad-10"  valign="middle">               
           <img src="/_files/images/website/wrong.gif" alt="" />  
        </td>                                                         
        </tr>                                                         
        </table></td></tr><tr><td nowrap="nowrap" class="bix-td-option bix-td-radio" width="1%"  id="tdOptionNo_D_212"><input type="checkbox" class="result-option cls_212" id="optionAns_D_212"></td><td class="bix-td-option" width="1%">D.</td>
                         <td class="bix-td-option" width="99%" id="tdOptionDt_D_212"><table border="0" cellpadding="0" cellspacing="0">
        <tr>                                                          
        <td class="bix-inner-td-option"><i class="networking-code">access-list 10 deny 172.16.136.0 0.0.15.255</i></td>                                                         
        <td id="tdAnswerIMG_D_212" class="jq-img-answer mx-none mx-lpad-10"  valign="middle">               
           <img src="/_files/images/website/wrong.gif" alt="" />  
        </td>                                                         
        </tr>                                                         
        </table></td></tr></table><input type="hidden" class="jq-actual-answer"   id="optionAnswer_212" value="B" />
                     <input type="hidden" class="jq-selected-answer" id="optionSelAns_212" value="" />
                     
        <div class="bix-div-answer mx-none" id="divAnswer_212">
         <div class="div-ans-des-wrapper">
            <p><span class="ib-green">Your Answer:</span> Option <span class="jq-user-answer ib-gray ib-bold">(Not Answered)</span></p> 
            <p><span class="ib-green">Correct Answer:</span> Option <span class="ib-dgray ib-bold">B</span></p><p><span class="ib-green mx-uline">Explanation:</span></p><div class="bix-ans-description">First, you must know that a /21 is 255.255.248.0, which is a block size of 8 in the third octet. Counting by eight, this makes our subnet 144 in the third octet, and the wildcard for the third octet would be 7 since the wildcard is always one less than the block size.</div><p><span class="ib-green">Learn more problems on : <a target="_blank" href="/networking/security/">Security</a></span></p><p><span class="ib-green">Discuss about this problem : <a target="_blank" href="/networking/security/discussion-212">Discuss in Forum</a></span></p></div>  <br />
        </div><div class="jq-workspace">
            <div class="div-workspace-link mx-fs-13"><a href="javascript: void 0;" onclick="$('#divWorkspace_212').slideToggle('slow');" title="Workspace">[#]</a></div>
            <div class="mx-none" id="divWorkspace_212">
                <textarea class="div-workspace-box" rows="10" cols="50"></textarea>
            </div>
        </div> 
                </td>
            </tr>
            </table>