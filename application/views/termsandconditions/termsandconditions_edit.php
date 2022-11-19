   <!-- Page Wrapper -->
   <div class="page-wrapper">
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                    <div class="row align-items-center">
					<div class="col">
						<h3 class="page-title">Edit Terms & Conditions</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/termsandconditions">Terms & Conditions</a></li>
							<li class="breadcrumb-item active">Edit Terms & Conditions</li>
						</ul>
					</div>
					<div class="col-auto float-end ms-auto">
						<a href="<?php echo base_url(); ?>admin/termsandconditions" class="btn add-btn"><i class="fa fa-arrow-right"></i>Terms & Conditions</a>

					</div>
				</div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <form id="form1" action="<?php echo site_url('admin/termsandconditions/update') ?>"  id="termsandconditionsform" name="termsandconditionsform" method="post" accept-charset="utf-8">
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?>
                            <?php
                            if (isset($error_message)) {
                                echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                            }
                            ?>      
                            <?php echo $this->customlib->getCSRF(); ?>  
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Terms and Conditions</label>
                                            <textarea rows="4" class="form-control summernote" placeholder="Enter your message here" name="termsandconditions" id="termsandconditions" required><?= $edittermsandconditions['termsandconditions']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <input type="hidden" name="hid" id="hid" value="<?= $edittermsandconditions['id']; ?>">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->        
        </div>			
    </div>
    <!-- /Page Wrapper -->