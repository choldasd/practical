<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			<?php 
				$action = route('companies.store');
			?>
			
			<section class="content-header">
				<ol class="breadcrumb">
					<li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> Home > </a></li>
					<li><a href="<?php echo e(route('companies.index')); ?>">Company > </a></li>
					<li class="active"> Add</li>
				</ol>
			</section>
            <div class="card">
                <div class="card-header">Add Company</div>
				
							
				<form role="form" id="create_company" method="post" action="<?php echo e($action); ?>" enctype="multipart/form-data">
					
					<div class="card-body">
						<div class="row">
							<?php if(session('status')): ?>
								<div class="alert alert-success" role="alert">
									<?php echo e(session('status')); ?>

								</div>
							<?php endif; ?>
						
							<div class="col-md-12">
								<div class="form-group">
									<label for="name">Name</label>
									<input type="text" class="form-control" name="name" id="name" placeholder="Name" value="<?php echo e(old('name')); ?>">
								</div>
								<p class="cust_error" id="error_name"></p>
								
								<div class="form-group">
									<label for="email">Email</label>
									<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo e(old('email')); ?>">
								</div>
								<p class="cust_error" id="error_email"></p>
								
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
								
								<div class="form-group">
									<label for="website">Website</label>
									<input type="text" class="form-control" name="website" id="website" placeholder="Website" value="<?php echo e(old('website')); ?>">
								</div>
								<p class="cust_error" id="error_website"></p>
								
								<div class="form-group">
									<label for="logo">Logo</label>
									<input type="file" class="form-control" name="logo" id="logo" placeholder="Logo" >
								</div>
								<p class="cust_error" id="error_logo"></p>
								
								<button type="submit" class="btn btn-primary">Save</button>
							</div>
							
						</div>
					</div>
				</form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(url('public/assets/scripts/companies.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\practical\resources\views/admin/companies/create.blade.php ENDPATH**/ ?>