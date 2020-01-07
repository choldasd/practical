<?php if(!empty($companyList) && count($companyList)>0): ?>
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
		<?php $i=1; ?>
		<?php $__currentLoopData = $companyList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $companyDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr id="tr_<?php echo e($companyDetail->id); ?>" class="rowtr" rowid="<?php echo e($companyDetail->id); ?>">
			<td><?php echo e($i++); ?></td>			
			<td><img src="<?php echo e(url('public/storage/'.$companyDetail->id.'/'.$companyDetail->logo)); ?>"  height="50px" width="50px" alt="<?php echo e($companyDetail->logo); ?>" title="<?php echo e($companyDetail->name); ?>"/></td>
			<td><?php echo e($companyDetail->name); ?></td>
			<td><?php echo e($companyDetail->website); ?></td>
			<td><?php echo e($companyDetail->created_at); ?></td>
			<td> 
									
				<a href="javascript:void(0);" action="<?php echo e(route('companies.edit',array($companyDetail->id))); ?>" class="edit" title="Edit Company">
						<i class="fa fa-2x fa-pencil-square-o" aria-hidden="true"></i>
				</a>
				
				<a href="javascript:void(0);" action="<?php echo e(route('companies.destroy',array($companyDetail->id))); ?>" class="delete" title="Delete Company"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></a>
			</td>
		</tr>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</tbody>
</table>
<div class="custom_pagination"><?php echo $companyList->appends($search_para)->render(); ?> </div>

</div>
<?php else: ?>
<div >No record found! </div>
<?php endif; ?>

<?php /**PATH D:\xampp\htdocs\practical\resources\views/admin/companies/search.blade.php ENDPATH**/ ?>