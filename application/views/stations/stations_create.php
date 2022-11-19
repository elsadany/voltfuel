  
   <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                    <div class="row align-items-center">
					<div class="col">
						<h3 class="page-title">Create Station</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Stations</a></li>
							<li class="breadcrumb-item active">Create Station</li>
						</ul>
					</div>
					<div class="col-auto float-end ms-auto">
						<a href="<?php echo base_url(); ?>admin/stations" class="btn add-btn"><i class="fa fa-arrow-left"></i> Stations</a>

					</div>
				</div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <form action="<?php echo site_url('admin/stations/insert') ?>"  id="stationform" name="stationform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <?php
                            if (isset($error_message)) {
                                echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                            }
                            ?>      
                            <?php echo $this->customlib->getCSRF(); ?>  
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Station ID</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control" id="validationServer01" name="station_id" placeholder="" value="<?php echo set_value('station_id'); ?>" autocomplete="off" required>
                                            <div class="invalid-feedback"><?php echo form_error('station_id'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Station Name</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control" id="validationServer01" name="station_name" placeholder="" value="<?php echo set_value('station_name'); ?>" autocomplete="off" required>
                                            <div class="invalid-feedback"><?php echo form_error('station_name'); ?></div>
                                        </div>
                                    </div> 
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Station QR Code</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control" id="validationServer01" name="qr_code" placeholder="" value="<?php echo set_value('qr_code'); ?>" autocomplete="off" required>
                                            <div class="invalid-feedback"><?php echo form_error('qr_code'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Manufacturer</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control" id="validationServer01" name="manufacturer" placeholder="" value="<?php echo set_value('manufacturer'); ?>" autocomplete="off" required>
                                            <div class="invalid-feedback"><?php echo form_error('manufacturer'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Model No</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control" id="validationServer01" name="station_type" placeholder="" value="<?php echo set_value('station_type'); ?>" autocomplete="off" required>
                                            <div class="invalid-feedback"><?php echo form_error('station_type'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Date of Purchase</label>
                                            <input autofocus="" type="date" class="form-control" id="validationServer01" name="purchasedate" placeholder="" value="<?php echo set_value('purchasedate'); ?>">
                                            <div class="invalid-feedback"><?php echo form_error('purchasedate'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">No of Batteries</label><small class="req"> *</small>
                                            <input autofocus="" type="number" class="form-control" id="validationServer01" name="batteries" placeholder="" value="<?php echo set_value('batteries'); ?>" required>
                                            <div class="invalid-feedback"><?php echo form_error('batteries'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                        <label for="exampleInputEmail1">Enable</label><small class="req"> *</small>
                                        <select class="form-control" name="enabled">;
                                            <option value="yes">Enable</option>
                                            <option value ="no">Disable</option>
										</select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                        <label for="exampleInputEmail1">Select Outlet</label>
                                        <select class="form-control" name="outlet_name">
                                            <option value="yes">Select Outlet</option>
                                            <?php foreach($listoutlets as $outlet){
                                                echo "<option value=".$outlet['id'].">".$outlet['outlet_name']."</option>";
                                             } ?>
                                           
										</select>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                <div class="col-md-12">
                                <div class="profile-img-wrap edit-img">
                                        <img class="inline-block" id="loadstationimage" src="<?php echo base_url(); ?>backend/assets/img/profiles/avatar-02.jpg" alt="user">
                                        <div class="fileupload btn">
                                            <span class="btn-text" id="upload-button">add</span>
                                            <input class="upload" type="file" name="upfile" id="upfile" accept="image/*">
                                        </div>
									</div>
                                </div>
                                </div>
                                <div class="text-end">
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
    <script>
        $(document).ready(function(){
            $("#upfile").on('change', function() {
                readURL(this);
                uploadstationimage(this.files);
            });

            var readURL = function(input) {
            //console.log(input.files[0].name);
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#loadstationimage').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
}            
        });
    </script>