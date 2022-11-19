<style>
/* Set the size of the div element that contains the map */
#map {
  height: 400px;
  /* The height is 400 pixels */
  width: 100%;
  /* The width is the width of the web page */
}
</style>


<script>
let marker;
let map;
let origin;
let lati = parseFloat(<?php if($editoutlet['lat'] == ""){echo 23.614328;}else{echo $editoutlet['lat'];}; ?>);
let lngi = parseFloat(<?php if($editoutlet['lng'] == ""){echo 58.545284;}else{echo $editoutlet['lng'];}; ?>);
let geo = "<?php echo $editoutlet['geo_coordinates']; ?>";
console.log("Lari: "+lati);
console.log("Lngi: "+lngi);
function initMap() {
    origin = { lat: lati, lng: lngi };        
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 18,
        center: origin,
    });
    const geocoder = new google.maps.Geocoder();
    marker = new google.maps.Marker({
        position: origin,
        map,
        title: "<?php echo $editoutlet['outlet_name']; ?>",
    });

    map.addListener("click", (event) => {
        console.log("You clicked on: " + event.latLng);
        $('#lat').val(event.latLng.lat());
        $('#lng').val(event.latLng.lng());
        marker.setMap(null);
        marker = new google.maps.Marker({
                map,
                position: event.latLng,
        });

        if (isIconMouseEvent(event)) {
            console.log("You clicked on place:" + event.placeId);
            event.stop();
            if (event.placeId) {
                geocodePlaceId(geocoder, map, event.placeId);
            }
            }

    });


}

function isIconMouseEvent(e) {
  return "placeId" in e;
}

function geocodePlaceId(geocoder, map, placeId) {
  console.log("Geocoder Fetch Address...");

  geocoder
    .geocode({ placeId: placeId })
    .then(({ results }) => {
      if (results[0]) {
        //map.setZoom(11);
        map.setCenter(results[0].geometry.location);
        //$('#outlet_name').val(results[0].name);
        $('#address').val(results[0].formatted_address);
      } else {
        window.alert("No results found");
      }
    })
    .catch((e) => window.alert("Geocoder failed due to: " + e));
    }

</script>
   
   <!-- Page Wrapper -->
    <div class="page-wrapper">
        <div class="content container-fluid">
        
            <!-- Page Header -->
            <div class="page-header">
                    <div class="row align-items-center">
					<div class="col">
						<h3 class="page-title"><?php echo $title;?></h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Outlets</a></li>
							<li class="breadcrumb-item active"><?php echo $title;?></li>
						</ul>
					</div>
					<div class="col-auto float-end ms-auto">
						<a href="<?php echo base_url(); ?>admin/outlets" class="btn add-btn"><i class="fa fa-arrow-left"></i> Outlets</a>

					</div>
				</div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <form id="form1" action="<?php echo site_url('admin/outlets/update') ?>"  id="outletform" name="outletform" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                            <!-- <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                            <?php } ?> -->
                            <?php
                            if (isset($error_message)) {
                                echo "<div class='alert alert-danger'>" . $error_message . "</div>";
                            }
                            ?>      
                            <?php echo $this->customlib->getCSRF(); ?>  
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        <label for="exampleInputEmail1">Pick Location</label><small class="req"> *</small>
                                        <input type="hidden" name="lat" id="lat" value="<?php echo $editoutlet['lat']; ?>">
                                        <input type="hidden" name="lng" id="lng" value="<?php echo $editoutlet['lng']; ?>">
                                            <!--Google map-->
                                            <div id="map"></div>
                                            <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
                                            <script
                                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCvwJJct9nAQ90KFN3WmTQ1yLp5RG8JcUQ&callback=initMap&libraries=&v=weekly"
                                            async
                                            ></script>
                                                <!--Google Maps-->

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="row">
                                    <input type="hidden" name="id" id="id" value="<?php echo $editoutlet['id']; ?>">
                                    <div class="col-md-12">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Outlet Name</label><small class="req"> *</small>
                                            <input type="text" class="form-control" id="outlet_name" name="outlet_name" placeholder="" value="<?php echo $editoutlet['outlet_name']; ?>" required>
                                            <div class="invalid-feedback"><?php echo form_error('outlet_name'); ?></div>
                                        </div>
                                    </div>
                                     <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Address line:</label>
                                                    <input type="text" class="form-control" id="address" name="address" placeholder="" value="<?php echo $editoutlet['address']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>City:</label>
                                                    <input type="text" class="form-control" id="city" name="city" placeholder="" value="<?php echo $editoutlet['city']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>State/Province:</label>
                                                    <input type="text" class="form-control" id="province" name="province" placeholder="" value="<?php echo $editoutlet['province']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ZIP code:</label>
                                                    <input type="text" class="form-control" id="pincode" name="pincode" placeholder="" value="<?php echo $editoutlet['pincode']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Customer Support:</label>
                                                    <input type="text" class="form-control" id="support" name="support" placeholder="" value="<?php echo $editoutlet['support']; ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Operation Time:</label>
                                                    <input type="text" class="form-control" id="operation_time" name="operation_time" placeholder="" value="<?php echo $editoutlet['operation_time']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Operation Mode:</label>
                                                    <input type="text" class="form-control" id="operation_mode" name="operation_mode" placeholder="" value="<?php echo $editoutlet['operation_mode']; ?>"  required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Image 1:</label>
                                                    <input type="hidden" class="form-control" name="old_imgfile1" value="<?php echo $editoutlet['image1']; ?>">
                                                    <input class="filestyle form-control" type='file' name='upfile1' id="img_file1" size='20'/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Image 2:</label>
                                                    <input type="hidden" class="form-control" name="old_imgfile2" value="<?php echo $editoutlet['image2']; ?>">
                                                    <input class="filestyle form-control" type='file' name='upfile2' id="img_file2" size='20'/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Image 3:</label>
                                                    <input type="hidden" class="form-control" name="old_imgfile3" value="<?php echo $editoutlet['image3']; ?>">
                                                    <input class="filestyle form-control" type='file' name='upfile3' id="img_file3" size='20'/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Image 4:</label>
                                                    <input type="hidden" class="form-control" name="old_imgfile4" value="<?php echo $editoutlet['image4']; ?>">
                                                    <input class="filestyle form-control" type='file' name='upfile4' id="img_file4" size='20'/>
                                                </div>
                                            </div>
                                        </div>                                          
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
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