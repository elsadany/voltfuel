<!-- /Page Content -->
<?php
		if(isset($privacypolicylist))
		{
	?>
	<div class="row">
		<?php
			foreach($privacypolicylist as $item)
			{
		?>
		<div class="col-lg-12 col-sm-12 col-md-12 col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="dropdown dropdown-action profile-action">
						<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="<?php echo base_url();?>admin/privacypolicy/edit/<?= $this->enc_lib->encrypt($item['id']); ?>"><i class="fa fa-pencil m-r-5"></i> Edit</a>
							<a class="dropdown-item" href="<?php echo base_url();?>admin/privacypolicy/delete/<?= $this->enc_lib->encrypt($item['id']); ?>"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
						</div>

					</div>
					<h4 class="Project-title">Privacy Policy</h4>
					<p class="text-muted"> 
						<?php echo $item['privacypolicy'];?>
					</p>
				</div>
			</div>	
		</div>
		<?php
			}
		?>
	</div>
	<?php
		}
	?>
<!-- /Page Content -->
		
