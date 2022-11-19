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
						<h3 class="page-title">Stations View</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Dashboard</a></li>
							<li class="breadcrumb-item active">Stations</li>
						</ul>
					</div>
					<div class="col-auto float-end ms-auto">
						<a href="<?php echo base_url(); ?>admin/stations" class="btn add-btn"><i class="fa fa-arrow-left"></i>Stations List</a>
					</div>
                    <input id="deviceid" type = "hidden" value="<?php echo $deviceid;?>">
				</div>
                <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                <?php } ?>
			</div>
			<!-- /Page Header -->
       <!-- <?= print_r($batterieslist); ?> -->
		<div class="row">
			<div class="col-md-12">
				<div class="table-responsive" id="batteries-status">
				</div>
			</div>
		</div>


<!-- <script>
$(document).ready(function(e) {

var device_id = $('#deviceid').val();
checkbatteries(device_id);
});

function checkbatteries(device_id) {
console.log("TEst");
$.ajax({
url: getBaseURL + 'admin/stations/checkbatteries/' + device_id,
type: "POST",
data: { "device_id": device_id },
success: function(response) {
	//console.log( response ); // server response
	//var response = $.parseJSON(response);
	$('#batteries-status').html(response);
}

});
}

function eject(order_id) {
var device_id = $('#deviceid').val();
var url = getBaseURL + 'admin/stations/ejectbattery/' + device_id + '/' + order_id;
console.log(url);
$.ajax({
url: url,
data: { "device_id": device_id, "order_id": order_id },
success: function(response) {
	//console.log( response ); // server response
	//var response = $.parseJSON(response);
	$('#batteries-status').html('');
	checkbatteries(device_id);
	//alert(response);
}

});

}

</script> -->