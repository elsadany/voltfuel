			<!-- Page Wrapper -->
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						
						<div class="row">
							<div class="col">
								<h3 class="page-title">Pricing Plans</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active">Pricing Plans</li>
								</ul>
							</div>
							<div class="col-auto float-end ms-auto">
								<!-- <a href="<?php echo base_url();?>admin/pricings/create" class="btn add-btn"><i class="fa fa-plus"></i> Add Plan</a> -->
								<a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_plan"><i class="fa fa-plus"></i> Add Plan</a>
							</div>
						</div>
		  
				
					</div>
					<!-- /Page Header -->
                     <?= print_r($plans);?> 
					<?= print_r($categories) ?>
					<div class="row">
						<div class="col-lg-10 mx-auto">
						
							<!-- Plan Tab -->
							<div class="row justify-content-center mb-4">
								<div class="col-auto">
									<nav class="nav btn-group">
									<a href="#all" class="btn btn-outline-secondary active show" data-bs-toggle="tab">ALL</a>
										<?php foreach ($categories as $category){ ?>
											<a href="#<?php echo$category['category'];?>" class="btn btn-outline-secondary" data-bs-toggle="tab"><?php echo$category['category'];?></a>
										<?php } ?>
									</nav>
								</div>
							</div>
							<!-- /Plan Tab -->

							<!-- Plan Tab Content -->
							<div class="tab-content">
							<div class="tab-pane fade active show" id="all">
								
								<div class="row mb-30 equal-height-cards">
								<?php foreach ($categories as $category){ ?>
									<div class="col-md-4">
										<div class="card pricing-box">
											<div class="card-body d-flex flex-column">
												<div class="mb-4">
													<h3><?php echo $category['category'];?></h3>
													</div>
												<ul>
													<li><i class="fa fa-check"></i> <b>1 User</b></li>
													<li><i class="fa fa-check"></i> 5 Batteries </li>
												</ul>
											</div>
										</div>
									</div>
								<?php } ?>

								</div>
								
								<!-- Monthly Plan Details -->
								<div class="row">
									<div class="col-md-12">
										<div class="card card-table mb-0">
											<div class="card-header">
												<h4 class="card-title mb-0">Plan Details</h4>
											</div>
											<div class="card-body">
												<div class="table-responsive">
                                                    <table class="table table-striped custom-table datatable">
														<thead>
															<tr>
																<th>S.No</th>
																<th>Plan Name</th>
																<th>Plan Type</th>
																<th>Plan Category</th>
																<th>Plan Amount</th>
																<th>Plan Description</th>
																<th>Payment Mode</th>
																<th>Max rental period</th>
																<th>Hold Amount</th>
																<th>Actions</th>
															</tr>
														</thead>
                                                        <tbody>
                                                                <?php 
                                                                if(isset($plans)){
                                                                    $i=0; 
                                                                foreach($plans as $row){
                                                                    $i++; 
                                                                ?>
                                                                <tr>
                                                                    <td><?=$i?></td>
                                                                    <td><?=$row['plan_name']?></td>
                                                                    <td><?=$row['plan_type']?></td>
                                                                    <td><?=$row['plan_categoryid']?></td>
                                                                    <td><?=$row['plan_amount']?> ر.ع</td>
                                                                    <td><?=$row['plan_description']?></td>
                                                                    <td><?=$row['payment_mode_id']?></td>
                                                                    <td><?=$row['max_rental_period'].'hours'?></td>
                                                                    <td><?=$row['max_charges'].'ر.ع'?></td>
                                                                    <td class="text-end">
                                                                        <div class="dropdown dropdown-action">
                                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a class="dropdown-item" href="#"  onclick=getplandetails(<?=$row['id']?>) data-bs-toggle="modal" data-bs-target="#edit_plan"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                                <!-- <a class="dropdown-item" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a> -->
                                                                                <a class="dropdown-item" href="<?php echo base_url();?>admin/pricings/deleteplan/<?php echo $this->enc_lib->encrypt($row['id']);?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <?php

                                                                }
                                                            }?>
                                                            </tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
								<!-- /Monthly Plan Details -->
							
							</div>
								<?php foreach ($categories as $category){ ?>

								<div class="tab-pane fade" id="<?php echo$category['category'];?>">
								
									<div class="row mb-30 equal-height-cards">
										<div class="col-md-4">
											<div class="card pricing-box">
												<div class="card-body d-flex flex-column">
													<div class="mb-4">
														<h3><?php echo$category['category'];?></h3>
														<span class="display-4">0.000 ر.ع</span>
													</div>
													<ul>
														<li><i class="fa fa-check"></i> <b>1 User</b></li>
														<li><i class="fa fa-check"></i> 5 Batteries </li>
													</ul>
													<a href="#" class="btn btn-lg btn-secondary mt-auto" data-bs-toggle="modal" data-bs-target="#edit_plan">Edit</a>
												</div>
											</div>
										</div>
									</div>
									
									<!-- Monthly Plan Details -->
									<div class="row">
										<div class="col-md-12">
											<div class="card card-table mb-0">
												<div class="card-header">
													<h4 class="card-title mb-0">Plan Details</h4>
												</div>
												<div class="card-body">
													<div class="table-responsive">
														<table class="table table-hover table-center mb-0">
															<thead>
																<tr>
																<th>S.No</th>
																<th>Plan Name</th>
																<th>Plan Type</th>
																<th>Plan Category</th>
																<th>Plan Amount</th>
																<th>Plan Description</th>
																<th>Payment Mode</th>
																<th>Max rental period</th>
																<th>Hold Amount</th>
																<th>Actions</th>
																</tr>
															</thead>
                                                            <tbody>
                                                                <?php 
                                                                if(isset($plans)){
                                                                    $i=0; 
                                                                foreach($plans as $row){
                                                                    
                                                                    if($row['plan_categoryid']==$category['id']){
                                                                        $i++; 
                                                                ?>
                                                                <tr>
                                                                <td><?=$i?></td>
                                                                    <td><?=$row['plan_name']?></td>
                                                                    <td><?=$row['plan_type']?></td>
                                                                    <td><?=$row['plan_categoryid']?></td>
                                                                    <td><?=$row['plan_amount']?> ر.ع</td>
                                                                    <td><?=$row['plan_description']?></td>
                                                                    <td><?=$row['payment_mode_id']?></td>
                                                                    <td><?=$row['max_rental_period'].'hours'?></td>
                                                                    <td><?=$row['max_charges'].'ر.ع'?></td>
                                                                    <td class="text-end">
                                                                        <div class="dropdown dropdown-action">
                                                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                                <a class="dropdown-item" href="#"  onclick=getplandetails(<?=$row['id']?>) data-bs-toggle="modal" data-bs-target="#edit_plan"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                                                                <!-- <a class="dropdown-item" href="#" ><i class="fa fa-pencil m-r-5"></i> Edit</a> -->
                                                                                <a class="dropdown-item" href="<?php echo base_url();?>admin/pricings/deleteplan/<?php echo $this->enc_lib->encrypt($row['id']);?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <?php
                                                                    }
                                                                }
                                                            }?>
                                                            </tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- /Monthly Plan Details -->
								
								</div>

								
								<?php } ?>
							</div>
							<!-- /Plan Tab Content -->
						  
							<!-- Add Plan Modal -->
							<div class="modal custom-modal fade" id="add_plan" role="dialog" aria-hidden="true" data-focus="false">
								<div class="modal-dialog modal-md modal-dialog-centered">
									<div class="modal-content">
										<button type="button" class="close" data-bs-dismiss="modal"><i class="fa fa-close"></i></button>
										<div class="modal-body">
											<h5 class="modal-title text-center mb-3">Add Plan</h5>
											<form action="<?php echo site_url('admin/pricings/addplan') ?>"  method="post" accept-charset="utf-8">
												<?php
												if (isset($error_message)) {
													echo "<div class='alert alert-danger'>" . $error_message . "</div>";
												}
												?>      
												<?php echo $this->customlib->getCSRF(); ?>  
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label>Plan Name</label>
															<input id="planname" name="planname" type="text" placeholder="Free Trial" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Plan Amount</label>
															<input id="planamount" name="planamount" type="text" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Plan Type</label>
															<select class="form-control" name = "plantype"> 
																<option> Per Minute </option>
																<option> Hourly </option>
																<option> Monthly </option>
																<option> Yearly </option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>No of Swaps</label>
															<input id="planamount" name="planswaps" type="number" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Maximum Rental Period in Hours</label>
															<input id="maxrental" name="maxrental" type="number" class="form-control">
														</div>
													</div>
                                                    <div class="col-md-6">
														<div class="form-group">
															<label>Hold Amounr</label>
															<input id="holdamount" name="holdamount" type="number" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Validity in Months</label>
															<input id="validmonths" name="validmonths" type="number" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Plan Category</label>
															<select name="plancategory" id="plancategory" class="form-control"> 
															<?php foreach ($categories as $category){ ?>
																<option value="<?php echo $category['id'];?>"><?php echo $category['category'];?></option>
															<?php }?>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Payment Modes</label>
															<select id="paymentmode" name="paymentmode" class="form-control" multiple> 
																<option> Credit Cards </option>
																<option> Debit Cards </option>
																<option> Wallet </option>
															</select>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>Plan Description</label>
													<textarea class="form-control" name="plandescription" rows="4" cols="30"></textarea>
												</div>
												<!-- <div class="form-group">
													<label class="d-block">Status</label>
													<div class="status-toggle">
														<input type="checkbox" id="add_plan_status" class="check">
														<label for="add_plan_status" class="checktoggle">checkbox</label>
													</div>
												</div> -->
												<div class="m-t-20 text-center">
													<button class="btn btn-primary submit-btn">Submit</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!-- /Add Plan Modal -->

                            <!-- Add Plan Modal -->
							<div class="modal custom-modal fade" id="edit_plan" role="dialog" aria-hidden="true" data-focus="false">
								<div class="modal-dialog modal-md modal-dialog-centered">
									<div class="modal-content">
										<button type="button" class="close" data-bs-dismiss="modal"><i class="fa fa-close"></i></button>
										<div class="modal-body">
											<h5 class="modal-title text-center mb-3">Edit Plan</h5>
											<form action="<?php echo site_url('admin/pricings/updateplan') ?>"  method="post" accept-charset="utf-8">
												<?php
												if (isset($error_message)) {
													echo "<div class='alert alert-danger'>" . $error_message . "</div>";
												}
												?>      
												<?php echo $this->customlib->getCSRF(); ?> 
                                                <input id="plan_id" name="plan_id" type="hidden" placeholder="Free Trial" class="form-control">
 
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label>Plan Name</label>
															<input id="edit_planname" name="planname" type="text" placeholder="Free Trial" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Plan Amount</label>
															<input id="edit_planamount" name="planamount" type="text" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Plan Type</label>
															<select class="form-control" id="edit_plantype" name = "plantype"> 
																<option> Per Minute </option>
																<option> Hourly </option>
																<option> Monthly </option>
																<option> Yearly </option>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>No of Swaps</label>
															<input id="edit_planswaps" name="planswaps" type="number" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Maximum Rental Period in Hours</label>
															<input id="edit_maxrental" name="maxrental" type="number" class="form-control">
														</div>
													</div>
                                                    <div class="col-md-6">
														<div class="form-group">
															<label>Hold Amounr</label>
															<input id="edit_holdamount" name="holdamount" type="number" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Validity in Months</label>
															<input id="edit_validmonths" name="validmonths" type="number" class="form-control">
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Plan Category</label>
															<select name="plancategory" id="edit_plancategory" class="form-control"> 
															<?php foreach ($categories as $category){ ?>
																<option value="<?php echo $category['id'];?>"><?php echo $category['category'];?></option>
															<?php }?>
															</select>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label>Payment Modes</label>
															<select id="edit_paymentmode" name="paymentmode" class="form-control" multiple> 
																<option> Credit Cards </option>
																<option> Debit Cards </option>
																<option> Wallet </option>
															</select>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>Plan Description</label>
													<textarea class="form-control" id="edit_plandescription" name="plandescription" rows="4" cols="30"></textarea>
												</div>
												<!-- <div class="form-group">
													<label class="d-block">Status</label>
													<div class="status-toggle">
														<input type="checkbox" id="add_plan_status" class="check">
														<label for="add_plan_status" class="checktoggle">checkbox</label>
													</div>
												</div> -->
												<div class="m-t-20 text-center">
													<button class="btn btn-primary submit-btn">Submit</button>
												</div>
											</form>
										</div>
									</div>
								</div>
							</div>
							<!-- /Add Plan Modal -->
						  
						</div>
					</div>
					
                </div>
				<!-- /Page Content -->
				
            </div>
			<!-- /Page Wrapper -->


