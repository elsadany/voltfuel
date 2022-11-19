<style>
/* Set the size of the div element that contains the map */
#order_map {
    /* position: absolute!important; */
    height: 500px;
    width:100%;
}
</style> 

  <!-- Page Wrapper -->
	<div class="page-wrapper">
	
		<!-- Page Content -->
		<div class="content container-fluid">
		
			<!-- Page Header -->
			<div class="page-header">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="page-title">Orders View</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="">Dashboard</a></li>
							<li class="breadcrumb-item active">Orders</li>
						</ul>
					</div>
					<div class="col-auto float-end ms-auto">
						<a href="<?php echo base_url(); ?>admin/orders" class="btn add-btn"><i class="fa fa-arrow-left"></i>Orders List</a>
					</div>
				</div>
                <?php if ($this->session->flashdata('msg')) { ?>
                                <?php echo $this->session->flashdata('msg') ?>
                <?php } ?>
			</div>
			<!-- /Page Header -->
		<div id="printbody" style="display:none;">
			<style>
			table,td
			{
				border:1px solid black; 
				border-collapse:collapse;
			}
			img{
				width:25px;
				height:20px;
			}
			#table_order_map {
				height: 500px;
				width:100%;
			}
			</style>
			<!-- <table width=100%>
				<tr style="padding:20px;">
					<td colspan="2" align="center" style="padding:20px;">								
						<input type="hidden" name="issued_lati" id="tbl_issued_lati" value="<?php echo $orderdetails['issuedlat']; ?>">
						<input type="hidden" name="issued_lang" id="tbl_issued_lang" value="<?php echo $orderdetails['issuedlng']; ?>">
						<input type="hidden" name="returned_lati" id="tbl_returned_lati" value="<?php echo $orderdetails['returnedlat']; ?>">
						<input type="hidden" name="returned_lang" id="tbl_returned_lang" value="<?php echo $orderdetails['returnedlng']; ?>">
						<input type="hidden" name="issued_title" id="tbl_issued_title" value="<?php echo $orderdetails['issuedoutlet']; ?>">
						<input type="hidden" name="returned_title" id="tbl_returned_title" value="<?php echo $orderdetails['returnedoutlet']; ?>">
						<div id="table_order_map"></div>
						<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0mfS-i8O8T_766m6jLULBvc3dcUgKQUc&callback=initMap&v=weekly" async></script>
					</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><img src="<?php echo base_url(); ?>backend/images/voltafuel_small_active.png" height="200" widht="200"><spad><h2>VoltaFuel</h2></span></td>
				</tr>
				<tr>
					<td colspan="2"><p><img src="<?php echo base_url(); ?>backend/images/yellow.png"> <?php echo $orderdetails['issuedoutlet']; ?></p></td>
				</tr>
				<tr>
					<td colspan="2"><p><img src="<?php echo base_url(); ?>backend/images/red.png"> <?php echo $orderdetails['returnedoutlet']; ?></p></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><h4>Order Info</h4></td>
				</tr>
				<tr>
					<td>Started On : </td>
					<td align="right"><?php echo $orderdetails['issued_date'].", at ". $orderdetails['issued_time']; ?></td> 
				</tr>
				<tr>
					<td>Finished On: </td>
					<td align="right"><?php echo $orderdetails['returned_date'].", at ". $orderdetails['returned_time']; ?></td>
				</tr>
				<tr>
					<td>Tariff : </td>
					<td align="right"><?php echo $orderdetails['plan_amount'].'/'.$orderdetails['plan_type'] ?></td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td>Total : </td>
					<td align="right"><?php echo $orderdetails['total_amount'] ?></td>
				</tr>
			</table> -->
		</div>
		<!-- <?= print_r($orderdetails); ?> -->
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <p><img src="<?php echo base_url(); ?>backend/images/yellow.png"> <?php echo $orderdetails['issuedoutlet']; ?></p>
                                <!-- <p><img src="<?php echo base_url(); ?>backend/images/red.png"> <?php echo $orderdetails['returnedoutlet']; ?></p> -->
                                <h4 class="Project-title">Order Info</h4>
                                <div class="col-sm-12 col-lg-12 col-xl-12 m-b-20">
                                    <ul class="list-unstyled invoice-payment-details">
                                        <li>Started On : <span><?php echo $orderdetails['issued_date'].", at ". $orderdetails['issued_time']; ?></span></li>
                                        <li>Current On: <span><?php echo $orderdetails['cur_date'].", at ". $orderdetails['cur_time']; ?></span></li>
                                        <li>Tariff : <span><?php echo $orderdetails['plan_amount'].'/'.$orderdetails['plan_type'] ?></span></li>
                                    </ul>
                                </div>
                                <hr>
                                <div class="col-sm-12 col-lg-12 col-xl-12 m-b-20">
                                    <ul class="list-unstyled invoice-payment-details">
                                        <li>Total : <span><?php echo $orderdetails['total'] ?></span></li>
                                    </ul>
                                </div>
                                <div class="col-md-4" style="float:left">
                                    <!-- <a href="" id="pagePrint" class="btn add-btn"><i class="fa fa-print"></i>Print</a>  -->
                                    <a href="<?php echo base_url(); ?>admin/orders/pending_order_print/<?php echo $this->enc_lib->encrypt($orderdetails['order_id']); ?>"  class="btn add-btn"><i class="fa fa-print"></i>Print</a> 
                                </div>
                            </div>
                            <div class="col-md-7">
                                <input type="hidden" name="issued_lati" id="issued_lati" value="<?php echo $orderdetails['issuedlat']; ?>">
                                <input type="hidden" name="issued_lang" id="issued_lang" value="<?php echo $orderdetails['issuedlng']; ?>">
                                <input type="hidden" name="issued_title" id="issued_title" value="<?php echo $orderdetails['issuedoutlet']; ?>">
                                <div id="order_map"></div>
                                <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
                                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA0mfS-i8O8T_766m6jLULBvc3dcUgKQUc&callback=initMap&v=weekly" async></script>
                                <!--Google Maps-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>			
            <div class="col-md-1"></div>
        </div>



<script>
let marker3,marker4;
let tbl_issued_lati = "<?= $orderdetails['issuedlat']; ?>";
let tbl_issuedlati = parseFloat(tbl_issued_lati);
let tbl_issued_lang = "<?= $orderdetails['issuedlng']; ?>";
let tbl_issuedlang = parseFloat(tbl_issued_lang);
let tbl_issuedtitle ="<?= $orderdetails['issuedoutlet']; ?>";
tbl_lati = parseFloat(23.614328);
tbl_lngi = parseFloat(58.545284);
console.log(tbl_lati,tbl_lngi);
function initMap()
{
    tbl_map = new google.maps.Map(document.getElementById("order_map"), {
        zoom: 15,
        center:  new google.maps.LatLng(tbl_lati, tbl_lngi),
    });

    const tbl_issuedlatLng = new google.maps.LatLng(tbl_issuedlati, tbl_issuedlang);
    marker3 = new google.maps.Marker({
    position: tbl_issuedlatLng,                
    icon: {
      scaledSize: new google.maps.Size(50, 50),
      url: "http://maps.google.com/mapfiles/ms/icons/yellow-dot.png",
      scale: 10,
    },
    map: tbl_map,
    title: tbl_issuedtitle,
    });

}
</script>