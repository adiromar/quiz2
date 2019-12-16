@extends ('layouts.admin')

@section('styles')
<style>
	.role-btn, .role-btn:hover{ 
	    padding: 4px 6px;
	    color: white;
	    border-radius: 5px;
	}
	.promote{
		background-color: #272c33;
	}
	.demote{
		background-color: darkred;
	}
	.chkrole{
		color: chocolate;
    	font-weight: 700;
	}
</style>
@endsection

@section('content')


<div class="container">
	<div class="card">
		<div class="card-body">
			<div class="card-title"><h5>Manage Menu:</h5></div>
			<div class="card-text">
				<form action="{{ route('menu.store') }}" method="post">
					<input name="_token" type="hidden" value="{{ csrf_token() }}"/>

					<div class="form-group">
						<label for="link"><b>Choose 10 Categories to show in Menu</b></label><br>
						<label for="">Main Categories:</label><br>
						<div class="col-md-3 mt-1">
							<input type="checkbox" value="comprehensive" name="comp" 
							{{ $menutype_comp ? 'checked' : '' }}>&nbsp;Comprehensive
						</div>
						@foreach( $main as $c )
						<div class="col-md-3 mt-1">
							<input type="checkbox" value="{{ $c->slug }}" name="main[]" 
							{{ in_array($c->slug,$menutype_main) == true ? 'checked' : '' }}>&nbsp;{{ $c->main_category_name }}
						</div>
						@endforeach
						<div class="col-md-12">
							&nbsp;
						</div>
						<label for="" class="mt-1">Sub-Categories:</label><br>
						@foreach( $subs as $c )
						<div class="col-md-3 mt-1">
							<input type="checkbox" value="{{ $c->slug }}" name="subs[]"
							{{ in_array($c->slug,$menutype_sub) == true ? 'checked' : '' }}>&nbsp;{{ $c->category_name }}
						</div>
						@endforeach

					</div>	

					<div class="col-md-12 form-group mt-3">
						<input type="submit" class="btn btn-success" name="submit" value="Submit">
					</div>

				</form>
			</div>	
		</div>
	</div>
</div>

@endsection