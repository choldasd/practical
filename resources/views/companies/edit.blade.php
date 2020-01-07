@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			
			<section class="content-header">
				<ol class="breadcrumb">
					<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home > </a></li>
					<li class="active"> My Profile</li>
				</ol>
			</section>
            <div class="card">
                <div class="card-header">My Profile</div>
				
					<div class="card-body">
						@if(!empty($companyDetail))
							@php
								$name = $companyDetail->name;
								$email = $companyDetail->email;
								$website = $companyDetail->website;
								$logo = $companyDetail->logo;
								$action = route('company.update',$companyDetail->id);
								
							@endphp
							<div class="row">
								
								<div class="col-md-12">
									<form role="form" id="edit_company" method="post" action="{{$action}}" enctype="multipart/form-data">
										@method('PUT')
									
										<div class="form-group">
											<label for="name">Name</label>
											<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="@if(!empty($name)){{$name}}@else{{old('name')}}@endif">
										</div>
										<p class="cust_error" id="error_name"></p>
										
										<div class="form-group">
											<label for="email">Email</label>
											<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="@if(!empty($email)){{$email}}@else{{old('email')}}@endif">
										</div>
										<p class="cust_error" id="error_email"></p>
										
										<div class="form-group">
											<label for="website">Website</label>
											<input type="text" class="form-control" name="website" id="website" placeholder="Website" value="@if(!empty($website)){{$website}}@else{{old('website')}}@endif">
										</div>
										<p class="cust_error" id="error_website"></p>
										
										<div class="form-group">
											<label for="logo">Logo</label>
											<input type="file" class="form-control" name="logo" id="logo" placeholder="Logo" >
										</div>
										<p class="cust_error" id="error_logo"></p>
										
										<div class="form-group">
											<label for="password">Password</label>
											<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="{{old('password')}}">
										</div>
										<p class="cust_error" id="error_password"></p>
										
										<div class="form-group">
											<label for="password_confirmation">Confirm Password</label>
											<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password confirmation" value="{{old('password_confirmation')}}">
										</div>
										<p class="cust_error" id="error_password"></p>
										
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<button type="submit" id="update_company" class="btn btn-primary">Upadate</button>
									</form>	
								</div>
								
							</div>
						@else
						<div >No record found! </div>
						@endif
					</div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{url('public/assets/scripts/companies.js')}}"></script>
@endpush
