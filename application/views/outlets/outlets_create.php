<!-- <style>
/* Set the size of the div element that contains the map */
#map {
  height: 400px;
  /* The height is 400 pixels */
  width: 100%;
  /* The width is the width of the web page */
}
</style>


<script>
    function initMap() {
        const muscat = { lat: 23.614328, lng: 58.545284 };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: muscat,
        });
        // Create the initial InfoWindow.
        let infoWindow = new google.maps.InfoWindow({
            content: "Click the map to get Lat/Lng!",
            position: myLatlng,
        });

        infoWindow.open(map);
        // Configure the click listener.
        map.addListener("click", (mapsMouseEvent) => {
            // Close the current InfoWindow.
            infoWindow.close();
            // Create a new InfoWindow.
            infoWindow = new google.maps.InfoWindow({
            position: mapsMouseEvent.latLng,
            });
            infoWindow.setContent(
            JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2)
            );
            infoWindow.open(map);
        });
}

</script> -->

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
let lati = parseFloat(<?php echo 23.614328; ?>);
let lngi = parseFloat(<?php echo 58.545284; ?>);
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
						<h3 class="page-title">Create Outlet</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/outlets">Outlets</a></li>
							<li class="breadcrumb-item active">Create Outlet</li>
						</ul>
					</div>
					<div class="col-auto float-end ms-auto">
						<a href="<?php echo base_url(); ?>admin/outlets" class="btn add-btn"><i class="fa fa-arrow-right"></i> Outlets</a>

					</div>
				</div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-0">
                        <div class="card-body">
                            <form id="form1" action="<?php echo site_url('admin/outlets/create') ?>"  id="outletform" name="outletform" method="post" accept-charset="utf-8">
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
                                    <div class="col-md-6">
                                        <div class="form-group">                               
                                            <label for="exampleInputEmail1">Outlet Name</label><small class="req"> *</small>
                                            <input autofocus="" type="text" class="form-control is-invalid" id="validationServer01" name="outlet_name" id="outlet_name" placeholder="" value="<?php echo set_value('outlet_name'); ?>" required>
                                            <div class="invalid-feedback"><?php echo form_error('book_title'); ?></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Pick Location</label><small class="req"> *</small>
                                            <input type="hidden" name="geo_coordinates" id="geo_coordinates">
                                            <!--Google map-->
                                            <div id="map"></div>
                                            <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
                                            <script
                                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0mfS-i8O8T_766m6jLULBvc3dcUgKQUc&callback=initMap&libraries=&v=weekly"
                                            async
                                            ></script>
                                                <!--Google Maps-->

                                        </div>
                                    </div>
                                    <div class="col-md-6">
    
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Address line:</label>
                                                    <input type="text" class="form-control" name="address" id="address" placeholder="" value="<?php echo set_value('address'); ?>"  required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>State/Province:</label>
                                                    <input type="text" class="form-control" name="state_province" id="state_province" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>ZIP code:</label>
                                                    <input type="text" class="form-control" name="zipcode" id="zipcode" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>City:</label>
                                                    <input type="text" class="form-control" name="city" id="city" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Image 1:</label>
                                                    <input class="filestyle form-control" type='file' name='img_file1' id="img_file1" size='20'  required/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Image 2:</label>
                                                    <input class="filestyle form-control" type='file' name='img_file2' id="img_file2" size='20'  required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Image 3:</label>
                                                    <input class="filestyle form-control" type='file' name='img_file3' id="img_file3" size='20'  required/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Image 4:</label>
                                                    <input class="filestyle form-control" type='file' name='img_file4' id="img_file4" size='20'  required/>
                                                </div>
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