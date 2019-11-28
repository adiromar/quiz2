@extends('layouts.admin')

@section('content')

<div class="container">
	
	<div class="row">
		
		<div class="col-md-12 mt-4 mb-5">
			
			<div class="card crd_border p-4">

                <div class="card-header"><b><i class="ti-pencil-alt"></i> Create Comprehensive Q's Category</b></div>
                <div class="card-body card-block">
                    <form action="{{ route('comprehensive.category.store') }}" method="post" >
    
                        {{-- csrf token --}}
                        <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
    
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">Category Name:</div>
                                    <input type="text" id="maincat" name="main_category_name" class="form-control" required>
                                    <div class="input-group-addon"><i class="fa fa-list"></i></div>
                                </div>
                                </div>
                                <div class="form-actions form-group">
                                <button type="submit" name="go" class="btn btn-primary btn-sm">Submit</button>
                                </div>
                    </form>
                </div>

                <div class="card-header"><b>View All</b></div>

                <table class="table table-condensed table-bordered">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    @if( count( $categories ) > 0 )

                    <tbody>
                        @foreach( $categories as $cat )
                        
                        <tr>
                            <td>{{ $cat->id }}</td>
                            <td>{{ $cat->title }}</td>
                            <td> {{ $cat->created_at }} </td>
                            <td>

                            <form action="{{ route('comprehensive.category.delete', $cat->id) }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field("DELETE") }}
                                <input type="submit" name="submit" onclick="return check_del();" value="Delete" class="btn btn-sm btn-danger">
                            </form>

                            </td>
                        </tr>

                        @endforeach
                    </tbody>

                    @else

                    <tbody>
                        <tr>
                            <td colspan="3">No Categories added at the moment.</td>
                        </tr>
                    </tbody>

                    @endif

                </table>

            </div>
        </div>
        
    </div>
</div>

<script type="text/javascript">
    function check_del(){
    var r=confirm("Confirm Delete this Data?")
        if (r==false)
        return false;
  }
</script>

@endsection