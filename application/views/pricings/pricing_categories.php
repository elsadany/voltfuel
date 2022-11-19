<?php print_r($categories);?>

<!-- Page Wrapper -->
<div class="page-wrapper">

	<!-- Page Content -->
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col">
					<h3 class="page-title">Pricing Categories</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
						<li class="breadcrumb-item active">Accounts</li>
					</ul>
				</div>
				<div class="col-auto float-end ms-auto">
					<a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_categories"><i class="fa fa-plus"></i> Add Categories</a>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive">
					<table class="table table-striped custom-table mb-0">
						<thead>
							<tr>
								<th>#</th>
								<th>Category Name </th>
								<th>Status</th>
								<th class="text-end">Action</th>
							</tr>
						</thead>
						<tbody>

						<?php 
						$i=0;
						foreach($categories as $category){
							$i++;
						?>
							<tr>
							<td><?php echo $i;?>
							<td><?php echo $category['category'];?></td>
							<td>
								<div class="dropdown action-label" id="pricingactive<?= $category['id'] ?>">
								<?php if ($category['is_active'] == 'yes'){;?>
									<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Active </a>
								<?php }else{?>
									<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Inactive </a>
								<?php }?>
									<div class="dropdown-menu">
										<a class="dropdown-item"  onclick=makepricingactive(<?= $category['id'] ?>)><i class="fa fa-dot-circle-o text-success"></i> Active</a>
										<a class="dropdown-item" onclick=makepricinginactive(<?= $category['id'] ?>)><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>
									</div>
								</div>
							</td>
							<td class="text-end">
								<div class="dropdown dropdown-action">
									<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<!-- <a class="dropdown-item" href="<?php echo base_url();?>admin/pricings/editcategory/<?php echo $this->enc_lib->encrypt($category['id']);?>"><i class="fa fa-pencil m-r-5"></i> Edit</a> -->
										<a class="dropdown-item openeditmodal" href="#" data-bs-toggle="modal" data-id="<?php echo $category['id'];?>" data-category ="<?php echo $category['category'];?>" data-bs-target="#edit_categories"><i class="fa fa-pencil m-r-5"></i> Edit</a>
										<a class="dropdown-item" href="<?php echo base_url();?>admin/pricings/deletecategory/<?php echo $this->enc_lib->encrypt($category['id']);?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
									</div>
								</div>
							</td>
							</tr>
						<?php }?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- /Page Content -->
	
	<!-- Add Holiday Modal -->
	<div class="modal custom-modal fade" id="add_categories" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Categories</h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
						<form action="<?php echo site_url('admin/pricings/addcategory') ?>"  method="post" accept-charset="utf-8">
						<?php
						if (isset($error_message)) {
							echo "<div class='alert alert-danger'>" . $error_message . "</div>";
						}
						?>      
						<?php echo $this->customlib->getCSRF(); ?>  
						<div class="form-group">
							<label>Categories Name <span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="category_name">
						</div>
						
						<div class="submit-section">
							<button class="btn btn-primary submit-btn">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Add Holiday Modal -->
	
	<!-- Add Holiday Modal -->
	<div class="modal custom-modal fade" id="edit_categories" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Categories</h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				<form action="<?php echo site_url('admin/pricings/editcategory') ?>"  method="post" accept-charset="utf-8">
						<?php
						if (isset($error_message)) {
							echo "<div class='alert alert-danger'>" . $error_message . "</div>";
						}
						?>      
						<?php echo $this->customlib->getCSRF(); ?>  
						<div class="form-group">
							<label>Categories Name <span class="text-danger">*</span></label>
							<input type="hidden" class="form-control" id="category_id" name="category_id" >
							<input class="form-control" type="text" name="category_name" id="category_name">
						</div>
						
						<div class="submit-section">
							<button class="btn btn-primary submit-btn">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Add Holiday Modal -->
</div>
<!-- /Page Wrapper -->

<script>
	function makepricingactive(id) {
		//Ajax Load data from ajax
		console.log(id);
		url = 'admin/pricings/makepricingactive/';
		$.ajax({
			url: getBaseURL() + url,
			type: "POST",
			data: {
				'csrf_test_name': getCookie('csrf_cookie_name'),
				'id':id
			},
			dataType: "JSON",
			success: function(data) {
				console.log(data);
				if (data.success) //if success close modal and reload ajax table
				{
					alert('success', 'Status Changed Successfully');
					$('#pricingactive'+id).empty();
					var html = '<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-success"></i> Active </a>';
					html += '<div class="dropdown-menu">';
					html += '<a class="dropdown-item" onclick=makepricingactive('+id+')><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
					html += '<a class="dropdown-item" onclick=makepricinginactive('+id+')><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
					html += '</div>';

					console.log(html);
					$('#pricingactive'+id).html(html);
					
				} else {
					alert('danger', data.error_string);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
				alert('danger', 'Error get data from ajax');
			}
		});
	}

	function makepricinginactive(id) {
		//Ajax Load data from ajax
		url = 'admin/pricings/makepricinginactive/';
		$.ajax({
			url: getBaseURL() + url,
			type: "POST",
			data: {
				'csrf_test_name': getCookie('csrf_cookie_name'),
				'id':id
			},
			dataType: "JSON",
			success: function(data) {
				console.log(data);
				if (data.success) //if success close modal and reload ajax table
				{
					alert('success', 'Status Changed Successfully');
					$('#pricingactive'+id).empty();
					var html = '<a href="" class="btn btn-white btn-sm btn-rounded dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-dot-circle-o text-danger"></i> Inactive </a>';
					html += '<div class="dropdown-menu">';
					html += '<a class="dropdown-item" onclick=makepricingactive('+id+')><i class="fa fa-dot-circle-o text-success"></i> Active</a>';
					html += '<a class="dropdown-item" onclick=makepricinginactive('+id+')><i class="fa fa-dot-circle-o text-danger"></i> Inactive</a>';
					html += '</div>';

					console.log(html);
					$('#pricingactive'+id).html(html);
				} else {
					alert('danger', data.error_string);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(errorThrown);
				alert('danger', 'Error get data from ajax');
			}
		});
	}

</script>


