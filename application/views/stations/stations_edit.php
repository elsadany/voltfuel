  
   <!-- Page Wrapper -->
   <div class="page-wrapper">
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                    <div class="row align-items-center">
					<div class="col">
						<h3 class="page-title">Edit Station</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Stations</a></li>
							<li class="breadcrumb-item active">Edit Station</li>
						</ul>
					</div>
					<div class="col-auto float-end ms-auto">
						<a href="<?php echo base_url(); ?>admin/stations" class="btn add-btn"><i class="fa fa-arrow-left"></i> Stations</a>
					</div>
				</div>
            </div>
            <!-- /Page Header -->
        <!-- <?= print_r($editstation); ?>  -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <form action="<?php echo site_url('admin/stations/update') ?>"  id="stationform" name="stationform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <?php
                            if (isset($error_message)) {
                                echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                            }
                            ?>      
                            <?php echo $this->customlib->getCSRF(); ?>  
                                <div class="row">
                                <input type="hidden" name="id" id="id" value="<?php echo $editstation['id']; ?>">
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Station ID</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control" id="validationServer01" name="station_id" placeholder="" value="<?php echo $editstation['station_id']; ?>" required>
                                            <div class="invalid-feedback"><?php echo form_error('station_id'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Station Name</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control" id="validationServer01" name="station_name" placeholder="" value="<?php echo $editstation['station_name']; ?>" required>
                                            <div class="invalid-feedback"><?php echo form_error('station_name'); ?></div>
                                        </div>
                                    </div>                                    
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Station QR Code</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control" id="validationServer01" name="qr_code" placeholder="" value="<?php echo $editstation['qr_code']; ?>" required>
                                            <div class="invalid-feedback"><?php echo form_error('qr_code'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Manufacturer</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control" id="validationServer01" name="manufacturer" placeholder="" value="<?php echo $editstation['manufacturer']; ?>" required>
                                            <div class="invalid-feedback"><?php echo form_error('manufacturer'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Model No</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control" id="validationServer01" name="station_type" placeholder="" value="<?php echo $editstation['station_type']; ?>" required>
                                            <div class="invalid-feedback"><?php echo form_error('station_type'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Date of Purchase</label>
                                            <input autofocus="" type="date" class="form-control" id="validationServer01" name="purchasedate" placeholder="" value="<?php echo $editstation['purchasedate']; ?>">
                                            <div class="invalid-feedback"><?php echo form_error('purchasedate'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">No of Batteries</label><small class="req"> *</small>
                                            <input autofocus="" type="number" class="form-control" id="validationServer01" name="batteries" placeholder="" value="<?php echo $editstation['batteries']; ?>" required>
                                            <div class="invalid-feedback"><?php echo form_error('batteries'); ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                        <label for="exampleInputEmail1">Enable</label><small class="req"> *</small>
                                        <select class="form-control" name="enabled">;
                                            <option <?php if ($editstation['is_active']=='yes'){echo 'selected';}?> value="yes">Enable</option>
                                            <option <?php if ($editstation['is_active']=='no'){echo 'selected';}?> value ="no">Disable</option>
										</select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">                               
                                        <label for="exampleInputEmail1">Select Outlet</label>
                                        <select class="form-control" name="outlet_name">
                                            <option value="yes">Select Outlet</option>
                                            <?php foreach($listoutlets as $outlet){
                                                if($outlet['id']==$editstation['outlet_id']){
                                                    echo "<option selected value=".$outlet['id'].">".$outlet['outlet_name']."</option>";
                                                }else{
                                                    echo "<option value=".$outlet['id'].">".$outlet['outlet_name']."</option>";
                                                }
                                             } ?>
                                           
										</select>
                                        </div>
                                        <input type="hidden" name="oldfile" id="oldfile" value="<?= $editstation['station_image']; ?>">
                                    </div>
                                </div>
                                <div class = "row">
                                <div class="col-md-12">
                                <div class="profile-img-wrap edit-img">
                                        <?php
                                            if($editstation['station_image']=='')
                                            {
                                        ?>
                                                <img class="inline-block" src="<?php echo base_url(); ?>backend/assets/img/profiles/avatar-02.jpg"  id="loadstationavater" alt="user">
                                        <?php
                                            }
                                            else
                                            {
                                        ?>
                                                <img class="inline-block"  id="loadstationimage" src="<?php echo base_url(); ?>uploads/stations/images/<?= $editstation['id']; ?>/<?= $editstation['station_image']; ?>" alt="user">
                                        <?php    
                                            }
                                        ?>
                                        
                                        <!-- <img class="inline-block" src="<?php echo base_url(); ?>backend/assets/img/profiles/avatar-02.jpg" alt="user"> -->
                                        <div class="fileupload btn">
                                            <span class="btn-text" id="upload-button">edit</span>
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

$(document).ready(function(e) {

var station_id = $('#id').val();
console.log(station_id);
var oldimgfile = $('#oldfile').val();
console.log(oldimgfile);

$("#upfile").on('change', function() {
    readURL(this);
    uploadstationimage(station_id, this.files, oldimgfile);
});

$("#upload-button").on('click', function() {
    $(".upload").click();
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

function uploadstationimage(station_id, img, oldimg) {
    data = new FormData();
    data.append('file', $('#upfile')[0].files[0]);
    data.append('id', station_id);
    data.append('oldimg', oldimg);
    var url = 'admin/stations/checkuploadimage'
    $.ajax({
        url: getBaseURL() + url,
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        success: function(response) {
            console.log(response);
            // if (data.success) //if success close modal and reload ajax table
            // {
            //     alert('success', 'Status Changed Successfully');
            // } else {
            //     alert('danger', data.error_string);
            // }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
            alert('danger', 'Error get data from ajax');
        }
    });
}

</script>