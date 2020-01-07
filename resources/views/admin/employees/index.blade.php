@section('title', 'Employees')
@extends('admin.layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
			<section class="content-header">
				<ol class="breadcrumb">
					<li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home > </a></li>
					<li class="active">Employees </li>
				</ol>
			</section>	
            <div class="card">
                <div class="card-header">Employee Search</div>
				<form id="search" method="get">
					<div class="card-body">
						
						@php 
							if(isset($_GET["keyword"]) && !empty($_GET["keyword"])){
								$keyword = $_GET["keyword"];
							}else{
								$keyword = old("keyword");
							}
							
							if(isset($_GET["company_id"]) && !empty($_GET["company_id"])){
								$company_id = $_GET["company_id"];
							}else{
								$company_id = old("company_id");
							}
							
							if(isset($_GET["sort_type"]) && !empty($_GET["sort_type"])){
								$sort_type = $_GET["sort_type"];
							}else{
								$sort_type = old("sort_type");
							}
							
							if(isset($_GET["sort_by"]) && !empty($_GET["sort_by"])){
								$sort_by = $_GET["sort_by"];
							}else{
								$sort_by = old("sort_by");
							}
							
						@endphp
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="keyword">Keyword</label>
									<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Keyword" value="{{$keyword}}">
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Company Name</label>
									<select name="company_id" id="company_id" class="form-control" >
										<option value="">Select company</option> 
										@foreach($companyList as $companyKey => $companyDetail)
											<option value="{{$companyDetail->id}}" >{{$companyDetail->name}}</option>
										@endforeach
									</select>	
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Sort type</label>
									<select class="form-control" name="sort_type" id="sort_type">
										<option value="id" @if($sort_type == "id") selected="selected" @endif>Id</option>
										<option value="full_name" @if($sort_type == "full_name") selected="selected" @endif>Name</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Sort by</label>
									<select class="form-control" name="sort_by" id="sort_by">
										<option value="DESC" @if($sort_by == "DESC") selected="selected" @endif>DESC</option>
										<option value="ASC" @if($sort_by == "ASC") selected="selected" @endif>ASC</option>
									</select>
								</div>
							</div>
						</div>
						
						<input type="hidden" name="page" id="page" value="{{$page}}"/>
						<button type="button" class="btn btn-success" id="search_btn">Search</button>
						<a class="btn btn-danger" href="{{route('employees.index')}}" >Clear</a>
					
					</div>
				</form>
            </div>
			<br>
			<div class="card">
				
				<div class="card-body">
					<div class="text-right"><a href="{{route('employees.create')}}" class="btn btn-info" >Add Employee</a></div><br>
					<div id="ajax_search">
						@include("admin.employees.search")
					</div>
				</div>
				
				<!-- Modal -->
				<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
								<!-- CSRF Token -->
								<input type="hidden" name="csrf-token" content="{{csrf_token()}}">
							</div>
							<div class="modal-body">
								<div id="editContent">
								
								</div>
							</div>
							<div class="modal-footer">
								
							</div>
						</div>
					</div>
				</div>
				
            </div>
			
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="{{url('public/assets/scripts/employee_list.js')}}"></script>
<script src="{{url('public/assets/scripts/employees.js')}}"></script>
@endpush

