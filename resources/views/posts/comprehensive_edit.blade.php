@extends('layouts.admin')

@section('content')

<div class="container">
	
	<div class="row">
		
		<div class="col-md-12 mt-4 mb-5">
			
			<div class="card crd_border p-4">
				
			<form action="{{ route('comprehensive.update', $para->id) }}" method="post">
				{{ csrf_field() }}
				{{ method_field('PUT') }}
			<div class="row pb-3">
			
				<div class="col-md-9">
					<label for="">Title</label>
					<input type="text" name="title" value="{{ $para->title }}" class="form-control">	
				</div>
				<div class="col-md-3">
					<label for="">Level</label>
					<input type="number" name="level" class="form-control" placeholder="Default: 1" value="{{ $para->level }}">
				</div>
				
			</div>
			
			<div class="row pb-3">
				<div class="col-md-5">
					<label for="">Choose Category</label>
					<select name="category" class="form-control">
						@foreach ( $cats as $cat )

						<option value="{{ $cat->id }}" {{ $para->comprehensive_categories_id == $cat->id ? 'selected' : '' }}>{{ $cat->title }}</option>

						@endforeach
					</select>
				</div>	
			</div>
			
			<div class="form-group">
				<label for="">Paragraph</label>
				<textarea name="paragraph" id="editor1">{{ $para->paragraph }}</textarea>
			</div>
				
			<!-- <div class="form-group wrapper">
				
				<div class="inner-wrapper">
					
				</div>

				<a href="#" id="addQues">+ Click Here to Add Questions For This Paragraph</a>

			</div> -->


			<input type="submit" name="submit" value="Update Question" class="btn btn-info">

			</form>

			</div>

		</div>

	</div>

</div>

@endsection