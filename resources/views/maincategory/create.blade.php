@extends('layouts.admin')

@section('content')

<div class="container">

	<div class="col-md-12 mt-4 mb-5">

	<div class="card">
        <div class="card-header"><b><i class="ti-pencil-alt"></i> Create Main Category</b></div>
            <div class="card-body card-block">
                <form action="{{ action('MainCategoryController@store') }}" method="post" class="">

					{{-- csrf token --}}
                	<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

                    <div class="form-group">
                        <div class="input-group">
                           <div class="input-group-addon">Main Category Name:</div>
                              <input type="text" id="maincat" name="main_category_name" class="form-control">
                              <div class="input-group-addon"><i class="fa fa-list"></i></div>
                            </div>
                          </div>
                          <div class="form-actions form-group">
                            <button type="submit" name="go" class="btn btn-primary btn-sm">Submit</button>
                          </div>
                </form>
        </div>
    </div>


		<div class="card mt-4">
			<div class="card-header"><b><i class="ti-view-grid"></i> View Main Category</b></div>

			<table class="table table-bordered table-striped table-hover table-responsive">
				<thead class="thead-dark">
					<tr>
						<th width="5%">S.N</th>
						<th width="40%">Main Category Name</th>
						<th width="20%">Created Date</th>
						<th width="15%">Status</th>
						<th width="15%"></th>
					</tr>
				</thead>
				<tbody>
					@if(count($main) > 0)
					<?php $m = 1; ?>
						@foreach($main as $mains)
						<tr>
							<td>{{ $m }}</td>
							<td>{{ $mains->main_category_name }}</td>
							<td>{{ $mains->created_at }}</td>
							<td><form action="{{ action('MainCategoryController@featured_cat', $mains->id) }}" method="post" >
											{{ csrf_field() }}
											{{ method_field('put') }}
											
											<select name="status" onchange="this.form.submit()" class="drp_col">
												<option value="0" {{ $mains->featured == '1' ? 'selected' : ''}}>Off</option>
												<option value="1" {{ $mains->featured == '1' ? 'selected' : ''}}>Featured</option>
											</select>
											  <input type="hidden" name="featured" value="{{ $mains->featured }}">
											  <input type="hidden" name="cat_id" value="{{ $mains->id }}" id="cat_id">
								</form></td>
								<td>
									<form method="POST" class="float-right" action="{{ action('MainCategoryController@destroy', $mains->id) }}">
											{{ csrf_field() }}
											{{ method_field('delete') }}
										<input type="submit" onclick="return check_del();" value="Delete" class="btn btn-danger btn-sm">
										</form>
								</td>
						</tr>
						@php $m++; @endphp
						@endforeach
					@endif
				</tbody>
			</table>
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