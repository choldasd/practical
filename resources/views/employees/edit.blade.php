@if(!empty($employeeDetail))
	@php
		$full_name = $employeeDetail->full_name;
		$email = $employeeDetail->email;
		$phone = $employeeDetail->phone;
		$action = route('employee.update',$employeeDetail->id);
		
	@endphp
	<div class="row">
				
		<div class="col-md-12">
			<form role="form" id="edit_employee" method="post" action="{{$action}}" enctype="multipart/form-data">
			@method('PUT')
				
				<div class="form-group">
					<label for="full_name">Name*</label>
					<input type="text" class="form-control" name="full_name" id="full_name" placeholder="Name" value="@if(!empty($full_name)){{$full_name}}@else{{old('full_name')}}@endif">
				</div>
				<p class="cust_error" id="error_full_name"></p>
				
				<div class="form-group">
					<label for="email">Email*</label>
					<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="@if(!empty($email)){{$email}}@else{{old('email')}}@endif">
				</div>
				<p class="cust_error" id="error_email"></p>
				
				<div class="form-group">
					<label for="phone">Phone*</label>
					<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="@if(!empty($phone)){{$phone}}@else{{old('phone')}}@endif">
				</div>
				<p class="cust_error" id="error_phone"></p>
				
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" id="update_employee" class="btn btn-primary">Upadate</button>
			</form>	
		</div>
		
	</div>
@else
<div >No record found! </div>
@endif

