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
<table width=100%>

	<tr style="padding:20px;">
		<td colspan="2" align="center" style="padding:20px;">								
			<input type="hidden" name="issued_lati" id="tbl_issued_lati" value="<?php echo $orderdetails['issuedlat']; ?>">
			<input type="hidden" name="issued_lang" id="tbl_issued_lang" value="<?php echo $orderdetails['issuedlng']; ?>">
			<input type="hidden" name="issued_title" id="tbl_issued_title" value="<?php echo $orderdetails['issuedoutlet']; ?>">
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
        <td colspan="2" align="center"><h4>Order Info</h4></td>
    </tr>
    <tr>
        <td>Started On : </td>
        <td align="right"><?php echo $orderdetails['issued_date'].", at ". $orderdetails['issued_time']; ?></td> 
    </tr>
    <tr>
        <td>Current On: </td>
        <td align="right"><?php echo $orderdetails['cur_date'].", at ". $orderdetails['cur_time']; ?></td>
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
        <td align="right"><?php echo $orderdetails['total'] ?></td>
    </tr>
</table>
<script>
    window.print();
	window.onafterprint = function(){
	 	window.location.replace('<?php echo base_url(); ?>admin/orders/view/<?= $this->enc_lib->encrypt($orderdetails['order_id']); ?>/<?= $this->enc_lib->encrypt($orderdetails['order_status']); ?>');
	 }
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
    tbl_map = new google.maps.Map(document.getElementById("table_order_map"), {
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

