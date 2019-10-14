@extends('layouts.admin')

@section('content')

<div class="container">
	<div class="row">

	@if(Session::has('message'))
        <p >{{ Session::get('message') }}</p>
     @endif

		<div class="col-md-12 mt-4">
			<div class="card crd_border">
        		<div class="card-header"><h4>Posts</h4>
        			
        		</div>

        		
        		<div class="row">
					<div class="card-body col-md-5">
						<a href="{{ route('posts.create') }}" class="btn btn-success btn-sm ml-3">+ Add New Post</a>
					</div>

					<div style="border-left: 3px solid lightgrey;height: 95px;"></div>

					<div class="col-md-5 float-right">
						<form method='post' action='{{ action('UploadPostController@uploadFilee') }}' enctype='multipart/form-data' >
       					{{ csrf_field() }}
						<label class="col-md-12">Upload Questions (CSV): </label>
						<input type="file" name="file" class="btn btn-light" required>
						<input type="submit" name="submit" value="Import" class="btn btn-primary ml-2">
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-12 mt-4">
			<div class="card crd_border">
        		<div class="card-header"><h4>View Your Posts</h4></div>
					<table class="table table-bordered table-hover table-responsive table-striped">
						<thead class="thead-dark">
							<tr>
								<th width="5%">S.N</th>
								<th width="40%">Post Name</th>
								<th width="20%">Category Name</th>
								<th width="20%">All Options</th>
								<th width="5%">Correct Option</th>
								<th width="5%">Level</th>
								<th width="10%">Created Date</th>
								<th width="10%">Edit</th>
								<th width="15%">Delete</th>
							</tr>
						</thead>
						<tbody>
							<?php $i=1; ?>
							@if(count($posts) > 0)
							@foreach($posts as $cat)
								<tr>
									<td>{{ $i }}</td>
									<td>{{ $cat->post_name }}</td>
									<td>{{ $cat->category_name }}</td>
									<td>A. {{ $cat->option_a }}<br>
										B. {{ $cat->option_b }}<br>
										C. {{ $cat->option_c }}<br>
										D. {{ $cat->option_d }}
									</td>
									<td>{{ $cat->correct_option }}</td>
									<td>{{ $cat->level }}</td>
									<td>{{ $cat->created_at }}</td>
									<td><a href="{{ url('/posts/' . $cat->id . '/edit') }}" class="btn btn-secondary btn-sm">Edit</a></td>
									<td>
										<form class="float-right" action="{{ action('PostsController@destroy', $cat->id) }}" method="POST">
									{{ csrf_field() }}
									{{ method_field('delete') }}
										<input type="submit" value="Delete" onclick="return check_del();" class="btn btn-danger btn-sm">
									</form>
									</td>
								</tr>

								<?php $i++; ?>
								@endforeach
						</tbody>
					</table>

					{{-- <div class="col-md-12 pagination-links-url"> --}}
						 {{ $posts->links()}}
					{{-- </div> --}}
							@else
								<table><tr><td colspan="5">No Posts Found</td></tr></table>
							@endif
			</div>
		</div>
	</div>
	

</div>


<script type="text/javascript">
	function check_del(){
    var r=confirm("Confirm Delete this Data?")
        if (r==true)
          window.location = url+"pages/delete_sin/"+title+id;
        else
          return false;
  }
</script>
@endsection