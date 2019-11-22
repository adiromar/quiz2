@extends('layouts.admin')

@section('content')

<div class="container">

	<div class="col-md-12 mt-4 mb-5">
	<div class="card">
        <div class="card-header">
        	<b>Create a Course:</b>
        </div>
        
        <div class="card-body card-block">
	
			<form action="{{ route('courses.update', $course->id) }}" method="post" enctype="multipart/form-data">
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
				{{ method_field('PUT') }}
				<div class="row">
					<div class="col-md-2 pt-1">
						<label for=""><strong>Title:*</strong></label>
					</div>
					<div class="col-md-9">
						<input type="text" class="form-control" name="title" value="{{ $course->title }}">
					</div>
				</div>

				<div class="row pt-3">
					<div class="col-md-2 pt-1">
						<label for=""><strong>Select a Topic:*</strong></label>
					</div>
					<div class="col-md-9">
						<select name="topic" class="form-control" required>
							
							<option value="{{ $course->topics->first()->id }}">{{ $course->topics->first()->title }}</option>
						@foreach ($topics as $topic)
							
							<option value="{{ $topic->id }}">{{ $topic->title }}</option>

						@endforeach

						</select>
					</div>
				</div>

				<div class="row pt-3">
					<div class="col-md-2 pt-1">
						<label for=""><strong>New Icon:</strong></label>
					</div>
					<div class="col-md-5">
						<input type="file" name="featured" class="form-control fileinp">
					</div>
					<div class="col-md-1"></div>
					<div class="col-md-4">
						@if ( $course->featured )

							<img src="{{ asset( $course->featured ) }}" alt="No Image" width="120" height="120">

						@endif
					</div>
				</div>

				<div class="row pt-3">
					<div class="col-md-11 pt-1">
						<label for=""><strong>Content:*</strong></label>
						<textarea name="content" id="editor1" rows="15" class="form-control">{!! $course->content !!}</textarea>
					</div>
				</div>

				<div class="row pt-4">
					<div class="col-md-3">
						<input type="submit" value="Update" class="btn btn-info btn-block">	
					</div>
					
				</div>

			</form>

        </div>

    </div>
    </div>
</div>


@endsection
