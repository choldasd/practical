@if(!empty($employeeList) && count($employeeList)>0)
<div class="table-responsive"> 
<table id="company_table" class="table table-bordered table-hover">
	<thead>
		<tr>
		<th>#</th>
		<th>Name</th>
		<th>Company Name</th>
		<th>Email</th>
		<th>Phone</th>
		<th>Created at</th>
		<th>Action</th>
		</tr>
	</thead>
	<tbody class="company_tbody">
		@php $i=1; @endphp
		
		@foreach($employeeList as $key => $employeeDetail)
			@php
				if(!empty($employeeDetail->user)){
					$companyDetail = $employeeDetail->user;
					$company_name = $companyDetail->name;
				}else{
					$company_name = "";
				}
			@endphp
			
		<tr id="tr_{{$employeeDetail->id}}" class="rowtr" rowid="{{$employeeDetail->id}}">
			<td>{{$i++}}</td>			
			<td>{{$employeeDetail->full_name}}</td>
			<td>{{$company_name}}</td>
			<td>{{$employeeDetail->email}}</td>
			<td>{{$employeeDetail->phone}}</td>
			<td>{{$employeeDetail->created_at}}</td>
			<td> 
								
				<a href="javascript:void(0);" action="{{route('employees.edit',array($employeeDetail->id))}}" class="edit" title="Edit Employee">
						<i class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i>
				</a>
				
				<a href="javascript:void(0);" action="{{route('employees.destroy',array($employeeDetail->id))}}" class="delete" title="Delete Employee"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<div class="custom_pagination">{!!$employeeList->appends($search_para)->render()!!} </div>

</div>
@else
<div >No record found! </div>
@endif