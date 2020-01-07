@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			@php 
				$action = route('employees.store');
			@endphp
			
			<section class="content-header">
				<ol class="breadcrumb">
					<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home > </a></li>
					<li><a href="{{route('employees.index')}}">Employee > </a></li>
					<li class="active"> Add</li>
				</ol>
			</section>
            <div class="card">
                <div class="card-header">Add Employee</div>
				
							
				<form role="form" id="create_employee" method="post" action="{{$action}}" enctype="multipart/form-data">
					
					<div class="card-body">
						<div class="row">
							
							<div class="col-md-12">
								<div class="form-group">
									<label>Company Name*</label>
									<select name="company_id" id="company_id" class="form-control" >
										<option value="">Select company</option> 
										@foreach($companyList as $companyKey => $companyDetail)
											<option value="{{$companyDetail->id}}" >{{$companyDetail->name}}</option>
										@endforeach
									</select>	
								</div>			
								<p class="help-block cust_error" id="error_company_id"></p>
							
								<div class="form-group">
									<label for="full_name">Name*</label>
									<input type="text" class="form-control" name="full_name" id="full_name" placeholder="Name" value="{{old('full_name')}}">
								</div>
								<p class="cust_error" id="error_full_name"></p>
								
								<div class="form-group">
									<label for="email">Email*</label>
									<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="{{old('email')}}">
								</div>
								<p class="cust_error" id="error_email"></p>
								
								<div class="form-group">
									<label for="phone">Phone*</label>
									<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="{{old('phone')}}">
								</div>
								<p class="cust_error" id="error_phone"></p>
								
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
							
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{url('public/assets/scripts/employees.js')}}"></script>
@endpush
