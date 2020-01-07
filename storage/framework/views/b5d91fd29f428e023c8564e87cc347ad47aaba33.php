<?php if(!empty($employeeDetail)): ?>
	<?php
		$full_name = $employeeDetail->full_name;
		$email = $employeeDetail->email;
		$phone = $employeeDetail->phone;
		$company_id = $employeeDetail->company_id;
		if(!empty($employeeDetail->user)){
			$companyDetail = $employeeDetail->user;
			$company_name = $companyDetail->name;
		}else{
			$company_name = "";
		}
		$action = route('employees.update',$employeeDetail->id);
		
	?>
	<div class="row">
				
		<div class="col-md-12">
			<form role="form" id="edit_employee" method="post" action="<?php echo e($action); ?>" enctype="multipart/form-data">
			<?php echo method_field('PUT'); ?>
				
				<div class="form-group">
					<label>Company Name*</label>
					<select name="company_id" id="company_id" class="form-control" >
						<option value="">Select company</option> 
						<?php $__currentLoopData = $companyList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companyKey => $companyDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							<option value="<?php echo e($companyDetail->id); ?>" <?php if($companyDetail->id == $company_id): ?> selected="selected" <?php endif; ?>><?php echo e($companyDetail->name); ?></option>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</select>	
				</div>			
				<p class="help-block cust_error" id="error_company_id"></p>
				
				<div class="form-group">
					<label for="full_name">Name*</label>
					<input type="text" class="form-control" name="full_name" id="full_name" placeholder="Name" value="<?php if(!empty($full_name)): ?><?php echo e($full_name); ?><?php else: ?><?php echo e(old('full_name')); ?><?php endif; ?>">
				</div>
				<p class="cust_error" id="error_full_name"></p>
				
				<div class="form-group">
					<label for="email">Email*</label>
					<input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?php if(!empty($email)): ?><?php echo e($email); ?><?php else: ?><?php echo e(old('email')); ?><?php endif; ?>">
				</div>
				<p class="cust_error" id="error_email"></p>
				
				<div class="form-group">
					<label for="phone">Phone*</label>
					<input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" value="<?php if(!empty($phone)): ?><?php echo e($phone); ?><?php else: ?><?php echo e(old('phone')); ?><?php endif; ?>">
				</div>
				<p class="cust_error" id="error_phone"></p>
				
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" id="update_employee" class="btn btn-primary">Upadate</button>
			</form>	
		</div>
		
	</div>
<?php else: ?>
<div >No record found! </div>
<?php endif; ?>

<?php /**PATH D:\xampp\htdocs\practical\resources\views/admin/employees/edit.blade.php ENDPATH**/ ?>