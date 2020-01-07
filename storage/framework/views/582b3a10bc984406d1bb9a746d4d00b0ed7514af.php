<?php if(!empty($companyDetail)): ?>
	<?php
		$name = $companyDetail->name;
		$email = $companyDetail->email;
		$website = $companyDetail->website;
		$logo = $companyDetail->logo;
		$action = route('companies.update',$companyDetail->id);
		
	?>
	<div class="row">
		<?php if(session('status')): ?>
			<div class="alert alert-success" role="alert">
				<?php echo e(session('status')); ?>

			</div>
		<?php endif; ?>
		
		<div class="col-md-12">
			<form role="form" id="edit_company" method="post" action="<?php echo e($action); ?>" enctype="multipart/form-data">
			<?php echo method_field('PUT'); ?>
			
				<div class="form-group">
					<label for="name">Name</label>
					<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php if(!empty($name)): ?><?php echo e($name); ?><?php else: ?><?php echo e(old('name')); ?><?php endif; ?>">
				</div>
				<p class="cust_error" id="error_name"></p>
				
				<div class="form-group">
					<label for="email">Email</label>
					<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php if(!empty($email)): ?><?php echo e($email); ?><?php else: ?><?php echo e(old('email')); ?><?php endif; ?>">
				</div>
				<p class="cust_error" id="error_email"></p>
				
				<div class="form-group">
					<label for="website">Website</label>
					<input type="text" class="form-control" name="website" id="website" placeholder="Website" value="<?php if(!empty($website)): ?><?php echo e($website); ?><?php else: ?><?php echo e(old('website')); ?><?php endif; ?>">
				</div>
				<p class="cust_error" id="error_website"></p>
				
				<div class="form-group">
					<label for="logo">Logo</label>
					<input type="file" class="form-control" name="logo" id="logo" placeholder="Logo" >
				</div>
				<p class="cust_error" id="error_logo"></p>
				
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo e(old('password')); ?>">
				</div>
				<p class="cust_error" id="error_password"></p>
				
				<div class="form-group">
					<label for="password_confirmation">Confirm Password</label>
					<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password confirmation" value="<?php echo e(old('password_confirmation')); ?>">
				</div>
				<p class="cust_error" id="error_password"></p>
				
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" id="update_company" class="btn btn-primary">Upadate</button>
			</form>	
		</div>
		
	</div>
<?php else: ?>
<div >No record found! </div>
<?php endif; ?>

<?php /**PATH D:\xampp\htdocs\practical\resources\views/admin/companies/edit.blade.php ENDPATH**/ ?>