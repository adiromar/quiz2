@extends('layouts.main')

@section('styles')

<style>
	.inner{
		border: 1px solid #f2f2f2;    	padding: 10px 15px;
	}
	.sub{
		font-weight:bold;font-size:15px
	}
</style>


@endsection

@section('content')


<div class="container">
	<div class="breadcrumb mb-4">
      <small class="sub">
        Please pay us through any of the two ways and upload the receipt here for confirmation.
      </small>
    </div>

	<div class="row">
		
		<div class="col-md-6">
			
			<form action="{{ route('payment.store') }}" method="post" enctype="multipart/form-data">
				{{ csrf_field() }}

				<div class="form-group">
					<label for="">Full Name:</label>
					<input type="text" name="fullname" class="form-control" required>
				</div>

				<div class="row pb-3">

					<div class="col-md-7">
						<label for="">Email:</label>
						<input type="email" name="email" class="form-control" required>
					</div>
					<div class="col-md-5">
						<label for="">Mobile No.</label>
						<input type="text" name="mobile_no" class="form-control" required>
					</div>
					
				</div>

				<div class="form-group">
					<label for="">Upload Receipt:</label>
					<input type="file" name="receipt" class="form-control" required>
				</div>

				<div class="form-group">
					<input type="submit" name="submit" value="Submit Payment" class="btn btn-success">
				</div>

			</form>

		</div>

		<div class="col-md-6">
			
			<div class="wrapper">
				
				<h5><strong>Payment Methods:</strong></h5>
				
				<div class="inner">
					<div class="row">
						<div class="col-md-6">
							<label for="">Esewa</label>

							Account No: 9841.........

						</div>
						<div class="col-md-6">
							<label for="">Bank Details</label>

							Account No: 009099909900

						</div>
					</div>
				</div>
				

			</div>

		</div>

	</div>

</div>

@endsection