<?php
$currency_symbol = $this->customlib->getCurrencyFormat();
?>
    <!-- Page Wrapper -->
	<div class="page-wrapper">
	
		<!-- Page Content -->
		<div class="content container-fluid">
		
			<!-- Page Header -->
			<div class="page-header">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="page-title">Orders</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Dashboard</a></li>
							<li class="breadcrumb-item active">Orders</li>
						</ul>
					</div>
					<!-- <div class="col-auto float-end ms-auto">
						<a href="<?php echo base_url(); ?>admin/outlets/create" class="btn add-btn"><i class="fa fa-plus"></i> Create Outlet</a>
						<div class="view-icons">
							<a href="<?php echo base_url(); ?>admin/outlets" class="grid-view btn btn-link <?php echo $gridview; ?>"><i class="fa fa-th"></i></a>
							<a href="<?php echo base_url(); ?>admin/outlets/list" class="list-view btn btn-link <?php echo $listview; ?>"><i class="fa fa-bars"></i></a>
						</div>
					</div> -->
				</div>
				<div id='msg'>
				</div>
                <!-- <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                <?php } ?> -->
			</div>
			<!-- /Page Header -->
			
			<!-- Search Filter -->
			<div class="row filter-row">
				<div class="col-sm-6 col-md-3">  
					<div class="form-group form-focus">
						<input type="text" class="form-control floating">
						<label class="focus-label">Outlet Name</label>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">  
					<div class="form-group form-focus">
						<input type="text" class="form-control floating">
						<label class="focus-label">Location Name</label>
					</div>
				</div>
				<div class="col-sm-6 col-md-3"> 
					<div class="form-group form-focus select-focus">
						<select class="form-control select floating" name="orderstatus" id="orderstatus"> 
							<!-- <option value="">Select Orders</option> -->
							<option value="all">All Orders</option>
							<option value="completed">Completed Orders</option>
                            <option value="pending">Pending Orders</option>
						</select>
						<label class="focus-label">Status</label>
					</div>
				</div>
				<div class="col-sm-6 col-md-3">  
					<a href="#" class="btn btn-success w-100"> Search </a>  
				</div>     
			</div>
<!-- Search Filter -->