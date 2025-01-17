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

	<div class="col-md-9">
		<div class="row">

		@if(count($submain) > 0)
			@foreach($submain as $smain)

				@if($smain->featured == true)
				<div class="col-md-4">
					<span style="color: #e5e544"><i class="fa fa-folder"></i></span><a href="{{ route('cat', [ $main->slug, $smain->slug, $smain->id, 1 ]) }}"> {{ $smain->category_name }}{{ ' ('. $smain->posts->count() . ') ' }}</a>
				</div>
				@endif
				
			@endforeach
		@else
			<p>No Cateogry Lists Found</p>
		@endif

		</div>
	</div>


@endsection