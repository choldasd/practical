@if(!empty($companyList) && count($companyList)>0)
<div class="table-responsive"> 
<table id="company_table" class="table table-bordered table-hover">
	<thead>
		<tr>
		<th>#</th>
		<th>Image</th>
		<th>Name</th>
		<th>Website</th>
		<th>Created at</th>
		<th>Action</th>
		</tr>
	</thead>
	<tbody class="company_tbody">
		@php $i=1; @endphp
		@foreach($companyList as $key => $companyDetail)
		<tr id="tr_{{$companyDetail->id}}" class="rowtr" rowid="{{$companyDetail->id}}">
			<td>{{$i++}}</td>			
			<td><img src="{{url('public/storage/'.$companyDetail->id.'/'.$companyDetail->logo)}}"  height="50px" width="50px" alt="{{$companyDetail->logo}}" title="{{$companyDetail->name}}"/></td>
			<td>{{$companyDetail->name}}</td>
			<td>{{$companyDetail->website}}</td>
			<td>{{$companyDetail->created_at}}</td>
			<td> 
									
				<a href="javascript:void(0);" action="{{route('companies.edit',array($companyDetail->id))}}" class="edit" title="Edit Company">
						<i class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i>
				</a>
				
				<a href="javascript:void(0);" action="{{route('companies.destroy',array($companyDetail->id))}}" class="delete" title="Delete Company"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
<div class="custom_pagination">{!!$companyList->appends($search_para)->render()!!} </div>

</div>
@else
<div >No record found! </div>
@endif

