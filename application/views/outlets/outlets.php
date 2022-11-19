			<div class="row">
				<?php 
				$count = 1;
				foreach ($listoutlets as $outlet) {
				?>
				<div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
					<div class="card">
						<div class="card-body">
							<div class="dropdown dropdown-action profile-action">
								<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="<?php echo base_url();?>admin/outlets/edit/<?php echo $this->enc_lib->encrypt($outlet['id']);?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
									<a class="dropdown-item" href="<?php echo base_url();?>admin/outlets/delete/<?php echo $this->enc_lib->encrypt($outlet['id']);?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
								</div>
							</div>
							<h4 class="Project-title"><a href="<?php echo base_url();?>admin/outlets/edit/<?php echo $this->enc_lib->encrypt($outlet['id']);?>"><?php echo $outlet['outlet_name'];?></a></h4>
							<small class="block text-ellipsis m-b-15">
								<span class="text-xs">10</span> <span class="text-muted">Batteries </span>
								<span class="text-xs">4</span> <span class="text-muted">Spaces</span>
							</small>
							<p class="text-muted"> <?php echo $outlet['address'];?>
							</p>
							<div class="pro-deadline m-b-15">
								<div class="sub-title">
									Operaton Mode:
								</div>
								<div class="text-muted">
									<?php echo $outlet['operation_mode'];?> <br>
									<?php echo $outlet['operation_time'];?>
								</div>
							</div>
							<div class="Outlet-members m-b-15">
								<div>Support :</div>
								<div class="text-muted">
									<?php echo $outlet['support'];?> <br>
								</div>
							</div>
							<div class="Outlet-members m-b-15">
								<div>Images :</div>
							</div>
						</div>
					</div>
				</div>	
				<?php 
				$count++;			
				}
				?>
			</div>
		</div>
		<!-- /Page Content -->
		
