@extends('layouts.admin')
@section('styles')

<style>
	label{ font-weight: bold }
</style>

@endsection
@section('content')

<div class="container">

	<div class="col-md-12 mt-4 mb-5">
	
	<div class="card">
		<div class="card-header"><b>Add a URL</b></div>
		<div class="card-body card-block">

			<form action="{{ route('videos.store') }}" method="post">
				{{ csrf_field() }}

			<div class="row">

				<div class="col-md-12">
					<label for="">Video Title</label>
					<input type="text" name="title" class="form-control" placeholder="Video Title" required>
				</div>
				<div class="col-md-12 pt-4">
					<label for="">Video Embed URL</label>
					<br>
					<small>Youtube url code is the code after https://youtube.com/watch?v=</small>
					<br><br>
					<input type="url" name="videourl" class="form-control" value="https://youtube.com/embed/Replace-This-With-Code-At-The-End-Of-Youtube-Video-Url" required>
				</div>
				
				<div class="col-md-12">
					<br>
					<label for="">Short Description</label>
					<textarea name="info" id="editor11" rows="8" class="form-control" required></textarea>

				</div>

				<div class="col-md-12">
					<br>
					<input type="submit" name="submit" value="Add URL" class="btn btn-success">
				</div>

			</div>

			</form>
			
		</div>
	</div>
	<div class="card">
        <div class="card-header">
        	<b>Video URLs:</b>
        </div>
            <div class="card-body card-block">

				<table class="table table-condensed table-bordered">
					
					<thead>
						<tr>
							<th width="80">S.N.</th>
							<th>Title</th>
							<th>Url</th>
							<th>Actions</th>
						</tr>
					</thead>
				@if ( $videos )
					<tbody>
						@foreach ( $videos as $vid )
	
						<tr>
							<td>{{ $vid->id }}</td>
							<td>{{ $vid->title }}</td>
							<td>{{ $vid->url }}</td>
							<td>
								<a href="" class="btn btn-info btn-sm btn-block">
									<i class="fa fa-edit"></i></a>
								<a href="" class="btn btn-danger btn-sm btn-block">
									<i class="fa fa-trash"></i></a>
							</td>
						</tr>

						@endforeach
					</tbody>
				@else
					<tbody>
						<tr>
							<td colspan="5">No videos at the moment.</td>
						</tr>
					</tbody>
				@endif
				</table>

            </div>
        </div>
    </div>
</div>


@endsection
