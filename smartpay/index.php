<html>
<head>
<title>VoltaFuel Payment</title>
</head>
<body>
<?php
include('Crypto.php');
//include('Functions.php');
//error_reporting(0);

$apikey =  $_GET['apikey'];
if ($apikey!='apikey'){
    die("Invalid Attempt");
}
$working_key='76AC4813EB375D252800EF8C82B1FF70';//Shared by CCAVENUES
$access_code='AVUA00JE14BH32AUHB';//Shared by CCAVENUES
$type = $_GET['paymenttype'];
$mobile_no = $_GET['mobileno'];
$data['merchant_id'] = '101';
$data['currency'] = 'OMR';
$data['redirect_url'] = "https://voltafuel.site/smartpay/response.php";
$data['cancel_url']="https://voltafuel.site/smartpay/response.php";
$data['language']="EN";
$data['customer_identifier']=''; //Alphanumeric, ‘@' and ‘.’ are allowed (70)

$data['si_type']='';
$data['si_mer_ref_no']='';
$data['merchant_param1']='';
$data['merchant_param2']='';
$data['merchant_param3']='';
$data['merchant_param4']='';
$data['merchant_param5']='';
$data['card_number']='5200000000000007'; //NUMERIC (16)
$data['expiry_month']='01'; //NUMERIC (2)
$data['expiry_year']='25'; //NUMERIC (2)
$data['cvv_number']='123'; //NUMERIC (3)
//$data['Customer_cardid']=''; //Numeric
//$data['saveCard']=''; //Expected values Y/N
//$data['']='';
//$data['']='';
//$data['']='';
$data['tid'] = $milliseconds = round(microtime(true) * 1000);

if($type=='order'){
    $data['amount'] = $_GET['amount'];
    $data['order_id'] = $_GET['orderid'];
    // $carddata = getcarddata($data['order_id']);
    // $data['card_number'] = '';
    // $data['expiry_year'] = '';
    // $data['expiry_month'] ='';
    // $data['cvv'] = '';
}else{
    $url = "https://admin.voltafuel.site/vfadmin/app/getplanamount?apikey=apikey&planid=".$_GET['orderid'];
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $resp = curl_exec($curl);
    curl_close($curl);
    $resp = json_decode($resp,true);
    $data['amount'] = $resp['msg'];
    $data['order_id'] = 'S'.$_GET['orderid'].time();
}



//print_r($data);

$merchant_data='';
foreach ($data as $key => $value){
    $merchant_data.=$key.'='.urlencode($value).'&';
}



$encrypted_data=encrypt($merchant_data,$working_key);



// $decrypted_data=decrypt($encrypted_data,$working_key);
// echo $merchant_data;
// echo '<br> Encrypted Data: ';
// echo $encrypted_data;
// echo '<br> Decrypted Data: ';
// echo $decrypted_data;
?>
<form method="post" name="redirect" action="https://mti.bankmuscat.com:6443/transaction.do?command=initiateTransaction"> 
<!-- <form method="post" name="redirect" action="https://smartpaytrns.bankmuscat.com/transaction.do?command=initiateTransaction">  -->
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
//echo "<input type=hidden name=access_code value=$access_code>";
?>
<!-- </form> -->
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>