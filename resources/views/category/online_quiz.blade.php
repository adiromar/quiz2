@extends('layouts.main')


	<style type="text/css">
		body {
    font-family: Open Sans;
}

h1 {
    text-align: center;
}

#title {
    text-decoration: underline;
}

#quiz {
    text-indent: 10px;
    display:none;
}

.button {
    border:4px solid;
    border-radius:5px;
    width: 60px;
    padding-left:5px;
    padding-right: 5px;
    position: relative;
    float:right;
    background-color: #DCDCDC;
    color: black;
    margin: 0 2px 0 2px;
}

.button.active {
    background-color: #F8F8FF;
    color: #525252;
}

button {
    position: relative;
    float:right;
}

.button a {
    text-decoration: none;
    color: black;
}

#container {
    width:50%;
    margin:auto;
    padding: 0 25px 40px 10px;
    background-color: #1E90FF;
    border:4px solid #B0E0E6;
    border-radius:5px;
    color: #FFFFFF;
    font-weight: bold;
    box-shadow: 5px 5px 5px #888;
    min-height: 500px;
}

ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

#prev {
    display:none;
}

#start {
    display:none;
    width: 90px;
}
	</style>

@section('content')

@php
    // dd($categoryy);
    $cname = ucfirst($categoryy->category_name);
@endphp
<div class="breadcrumb mb-4"><a href="{{ url('/') }}">Home</a><span class="sp-angle">»</span><a href="{{ url('cat/'.$cname.'/'.$categoryy->id.'') }}">{{ $cname }}</a><span class="sp-angle">»</span>Online Quiz</div>

<div class="container mb-5">
		<div id='container'>
			<div id='title'>
				<h1><i class="fa fa-question-circle"></i> Online Quiz</h1>
				<h4 style="text-align: center;">Category: {{ ucwords($categoryy->category_name) }}</h4>
				<p style="text-align: right;" class="length"></p>
			</div>
   			<br/>
  			<div id='quiz'></div>
    		<div class='button' id='next'><a href='#'>Next</a></div>
    		<div class='button' id='prev'><a href='#'>Prev</a></div>
    		<div class='button' id='start'> <a href='#'>Start Test</a></div>
        
        {{-- <input type="button" id="btnSubmitTest" value="submit"> --}}
    		<!-- <button class='' id='next'>Next</a></button>
    		<button class='' id='prev'>Prev</a></button>
    		<button class='' id='start'> Start Over</a></button> -->
    	</div>
</div>

<script src="http://code.jquery.com/jquery-3.3.1.min.js"
               integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
               crossorigin="anonymous"></script>
{{-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> --}}
      
		{{-- <script type="text/javascript" src='questions.json'></script> --}}
		{{-- <script type='text/javascript' src='jsquiz.js'></script> --}}

<script type="text/javascript">
(function() {
	var cat = @json($categoryy);
    var questions = @json($items);	

	// console.log(cat);
	// console.log(questions);
	
  // var questions = [{
  //   question: "What is 2*5?",
  //   choices: ["2", "5", "10", "15", "20"],
  //   correctAnswer: "2"
  // }, {
  //   question: "What is 3*6?",
  //   choices: [3, 6, 9, 12, 18],
  //   correctAnswer: 4
  // }, {
  //   question: "What is 8*9?",
  //   choices: [72, 99, 108, 134, 156],
  //   correctAnswer: 0
  // }, {
  //   question: "What is 1*7?",
  //   choices: [4, 5, 6, 7, 8],
  //   correctAnswer: 3
  // }, {
  //   question: "What is 8*8?",
  //   choices: [20, 30, 40, 50, 64],
  //   correctAnswer: 4
  // }];
  
  console.log(questions);

$('.length').append('Total Questions: ' + questions.length);

  var questionCounter = 0; //Tracks question number
  var selections = []; //Array containing user choices
  var quiz = $('#quiz'); //Quiz div object
  
  // Display initial question
  displayNext();
  
  // Click handler for the 'next' button
  $('#next').on('click', function (e) {
    e.preventDefault();
    
    // Suspend click listener during fade animation
    if(quiz.is(':animated')) {        
      return false;
    }
    choose();
    
    // If no user selection, progress is stopped
    if (isNaN(selections[questionCounter])) {
      alert('Please make a selection!');
    } else {
      questionCounter++;
      displayNext();
    }
  });
  
  // Click handler for the 'prev' button
  $('#prev').on('click', function (e) {
    e.preventDefault();
    
    if(quiz.is(':animated')) {
      return false;
    }
    choose();
    questionCounter--;
    displayNext();
  });
  
  // Click handler for the 'Start Over' button
  $('#start').on('click', function (e) {
    e.preventDefault();
    
    if(quiz.is(':animated')) {
      return false;
    }
    questionCounter = 0;
    selections = [];
    displayNext();
    $('#start').hide();
  });
  
  // Animates buttons on hover
  $('.button').on('mouseenter', function () {
    $(this).addClass('active');
  });
  $('.button').on('mouseleave', function () {
    $(this).removeClass('active');
  });
  
  // Creates and returns the div that contains the questions and 
  // the answer selections
  function createQuestionElement(index) {
    var qElement = $('<div>', {
      id: 'question'
    });
    // console.log(qElement);
    var header = $('<h2>Question ' + (index + 1) + ':</h2>');
    qElement.append(header);
    
    var question = $('<p>').append(questions[index].question);
    qElement.append(question);
    
    var radioButtons = createRadios(index);
    qElement.append(radioButtons);
    
    return qElement;
  }
  
  // Creates a list of the answer choices as radio inputs
  function createRadios(index) {
    var radioList = $('<ul>');
    var item;
    var input = '';
    for (var i = 0; i < questions[index].choices.length; i++) {
      item = $('<li><label class="col-md-12">');
      input = '<input type="radio" name="answer" value=' + i + ' /></label></li></ul>';

      // input += '<li class="show" style="display: none;"><input type="text" value='+ questions[index].correctAnswer +'></li>';
      // newinput = '<li class="this_show"></li>';
      input += questions[index].choices[i];
      item.append(input);
      radioList.append(item);
    }
    return radioList;
  }
  
  // Reads the user selection and pushes the value to an array
  function choose() {
    selections[questionCounter] = +$('input[name="answer"]:checked').val();
  }
  
  // Displays next requested element
  function displayNext() {
    quiz.fadeOut(function() {
      $('#question').remove();
      
      if(questionCounter < questions.length){
        var nextQuestion = createQuestionElement(questionCounter);
        quiz.append(nextQuestion).fadeIn();
        if (!(isNaN(selections[questionCounter]))) {
          $('input[value='+selections[questionCounter]+']').prop('checked', true);
        }
        
        // Controls display of 'prev' button
        if(questionCounter === 1){
          $('#prev').show();
        } else if(questionCounter === 0){
          
          $('#prev').hide();
          $('#next').show();
        }
      }else {
        var scoreElem = displayScore();
        quiz.append(scoreElem).fadeIn();
        // $('#next').show();
        $('#prev').show();
        $('#start').show();
        $('.show').show();
      }
    });
  }
  
  // Computes score and returns a paragraph element to be displayed
  function displayScore() {
    var score = $('<p>',{id: 'question'});

    var d =0;
    var numCorrect = 0;
    for (var i = 0; i < selections.length; i++) {

    	if (questions[i].correctAnswer == 'a'){
    		d = 0;
    	}else if (questions[i].correctAnswer == 'b'){
    		d = 1;
    	}else if (questions[i].correctAnswer == 'c'){
    		d = 2;
    	}else if (questions[i].correctAnswer == 'd'){
    		d = 3;
    	}
    	console.log(selections[i]);
    	console.log(questions[i].correctAnswer);
    	console.log(d);
      // if (selections[i] == questions[i].correctAnswer) {
      	if (selections[i] == d) {
      	
        numCorrect++;
      }
    }
    
    function SubmitTestButtonClickHandler(thisObj)
{
    var txtMsg = '';
    var intUAC = $("input.jq-selected-answer[value='']").length;
    if( intUAC > 0) txtMsg = "Total number of unanswered questions = " + intUAC + ".\n\n" ;
    
    if(confirm(txtMsg + 'Are you sure you want to submit the Test now?'))  /* Check for Time limit also. */
    {
        $(thisObj).attr('disabled', 'disabled');
        PopulateResultStatics();
    }
}

    savescore();
    function savescore(){
      var pers = (numCorrect / questions.length) * 100;
      var ptg = pers.toPrecision(3);
      // alert(ptg);
    }
    $('#btnSubmitTest').click(  function(){  display_results(this); });

    function display_results(thisObj){

      <?php
      DB::insert('insert into score_rankings (correct_score, percentage) values (?, ?)', [2, '23.3']); ?>
    }
      
    score.append('You got ' + numCorrect + ' questions out of ' +
                 questions.length + ' right!!!');
    per = (numCorrect / questions.length) * 100;
    score.append('<br><br> Test Percentage: ' + per.toPrecision(3) + ' %');
      
    return score;
  }
})();
		</script>

@endsection
