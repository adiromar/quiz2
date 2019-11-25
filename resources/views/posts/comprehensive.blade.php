@extends('layouts.admin')

@section('content')

<div class="container">
	
	<div class="row">
		
		<div class="col-md-12 mt-4 mb-5">
			
			<div class="card crd_border p-4">
				
			<form action="{{ route('comprehensive.store') }}" method="post">
				{{ csrf_field() }}

			<div class="row pb-3">
			
				<div class="col-md-9">
					<label for="">Title</label>
					<input type="text" name="title" value="{{ old('title') }}" class="form-control">	
				</div>
				<div class="col-md-3">
					<label for="">Level</label>
					<input type="number" name="level" class="form-control" placeholder="Default: 1" value="{{ old('level') }}">
				</div>
				
			</div>
			
			<div class="form-group">
				<label for="">Paragraph</label>
				<textarea name="paragraph" id="editor1">{{ old('paragraph') }}</textarea>
			</div>
				
			<div class="form-group wrapper">
				
				<div class="inner-wrapper">
					
				</div>

				<a href="#" id="addQues">+ Click Here to Add Questions For This Paragraph</a>

			</div>


			<input type="submit" name="submit" value="Submit Question" class="btn btn-info">

			</form>

			</div>

		</div>

	</div>

</div>

@endsection