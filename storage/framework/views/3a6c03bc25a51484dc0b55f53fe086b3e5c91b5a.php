<?php $__env->startSection('title', 'My Employees'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
			<section class="content-header">
				<ol class="breadcrumb">
					<li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-dashboard"></i> Home > </a></li>
					<li class="active">Employees </li>
				</ol>
			</section>	
            <div class="card">
                <div class="card-header">Employee Search</div>
				<form id="search" method="get">
					<div class="card-body">
						
						<?php 
							if(isset($_GET["keyword"]) && !empty($_GET["keyword"])){
								$keyword = $_GET["keyword"];
							}else{
								$keyword = old("keyword");
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
							
						?>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									<label for="keyword">Keyword</label>
									<input type="text" class="form-control" name="keyword" id="keyword" placeholder="Keyword" value="<?php echo e($keyword); ?>">
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="form-group">
									<label>Sort type</label>
									<select class="form-control" name="sort_type" id="sort_type">
										<option value="id" <?php if($sort_type == "id"): ?> selected="selected" <?php endif; ?>>Id</option>
										<option value="full_name" <?php if($sort_type == "full_name"): ?> selected="selected" <?php endif; ?>>Name</option>
									</select>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Sort by</label>
									<select class="form-control" name="sort_by" id="sort_by">
										<option value="DESC" <?php if($sort_by == "DESC"): ?> selected="selected" <?php endif; ?>>DESC</option>
										<option value="ASC" <?php if($sort_by == "ASC"): ?> selected="selected" <?php endif; ?>>ASC</option>
									</select>
								</div>
							</div>
						</div>
						
						<input type="hidden" name="page" id="page" value="<?php echo e($page); ?>"/>
						<button type="button" class="btn btn-success" id="search_btn">Search</button>
						<a class="btn btn-danger" href="<?php echo e(route('employee.index')); ?>" >Clear</a>
					
					</div>
				</form>
            </div>
			<br>
			<div class="card">
				
				<div class="card-body">
					<div class="text-right"><a href="<?php echo e(route('employee.create')); ?>" class="btn btn-info" >Add Employee</a></div><br>
					<div id="ajax_search">
						<?php echo $__env->make("employees.search", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
								<input type="hidden" name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(url('public/assets/scripts/employee_list.js')); ?>"></script>
<script src="<?php echo e(url('public/assets/scripts/employees.js')); ?>"></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\practical\resources\views/employees/index.blade.php ENDPATH**/ ?>