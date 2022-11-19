<?php include('Crypto.php')?>
<?php

	error_reporting(0);
	
	$workingKey='76AC4813EB375D252800EF8C82B1FF70';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);

	$dataArr = array();
	foreach ($decryptValues as $key => $value) {
		$orderdata = explode('=', $value);
		$dataArr[$orderdata[0]] = $orderdata[1];
	}

	echo json_encode($dataArr);

?>


