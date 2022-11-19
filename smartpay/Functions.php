<?php

error_reporting(0);

function getapi($url, $apidata) {
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
    return $data;
}
