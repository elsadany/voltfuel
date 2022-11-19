<html>
<head>
<title> Iframe</title>
</head>
<body>
<center>
<?php include('Crypto.php')?>
<?php 

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$working_key='';//Shared by CCAVENUES
	$access_code='';//Shared by CCAVENUES

	//using session for demo purpose. For production, store values in Database
	$_SESSION['order']['order_id'] = $_POST['order_id'];
	$_SESSION['order']['amount'] = $_POST['amount'];
	$_SESSION['order']['currency'] = $_POST['currency'];
	
	$merchant_data='';
	foreach ($_POST as $key => $value){
		$merchant_data.=$key.'='.urlencode($value).'&';
	}
	
	$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.

	$production_url='https://mti.bankmuscat.com:6443/transaction.do?command=initiateTransaction&encRequest='.$encrypted_data.'&access_code='.$access_code;
?>
<iframe src="<?php echo $production_url?>" id="paymentFrame" width="482" height="450" frameborder="0" scrolling="No" ></iframe>

<script type="text/javascript" src="jquery-1.7.2.js"></script>
<script type="text/javascript">
    	$(document).ready(function(){
    		 window.addEventListener('message', function(e) {
		    	 $("#paymentFrame").css("height",e.data['newHeight']+'px'); 	 
		 	 }, false);
	 	 	
		});
</script>
</center>
</body>
</html>

