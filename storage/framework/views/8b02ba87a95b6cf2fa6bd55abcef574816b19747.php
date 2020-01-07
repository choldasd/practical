<?php if(!empty($employeeList) && count($employeeList)>0): ?>
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
		<?php $i=1; ?>
		
		<?php $__currentLoopData = $employeeList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $employeeDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<?php
				if(!empty($employeeDetail->user)){
					$companyDetail = $employeeDetail->user;
					$company_name = $companyDetail->name;
				}else{
					$company_name = "";
				}
			?>
			
		<tr id="tr_<?php echo e($employeeDetail->id); ?>" class="rowtr" rowid="<?php echo e($employeeDetail->id); ?>">
			<td><?php echo e($i++); ?></td>			
			<td><?php echo e($employeeDetail->full_name); ?></td>
			<td><?php echo e($company_name); ?></td>
			<td><?php echo e($employeeDetail->email); ?></td>
			<td><?php echo e($employeeDetail->phone); ?></td>
			<td><?php echo e($employeeDetail->created_at); ?></td>
			<td> 
								
				<a href="javascript:void(0);" action="<?php echo e(route('employees.edit',array($employeeDetail->id))); ?>" class="edit" title="Edit Employee">
						<i class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i>
				</a>
				
				<a href="javascript:void(0);" action="<?php echo e(route('employees.destroy',array($employeeDetail->id))); ?>" class="delete" title="Delete Employee"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></a>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</tbody>
</table>
<div class="custom_pagination"><?php echo $employeeList->appends($search_para)->render(); ?> </div>

</div>
<?php else: ?>
<div >No record found! </div>
<?php endif; ?><?php /**PATH D:\xampp\htdocs\practical\resources\views/admin/employees/search.blade.php ENDPATH**/ ?>