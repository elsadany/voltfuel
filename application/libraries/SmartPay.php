<?php
if (!defined('BASEPATH'))
exit('No direct script access allowed');

Class SmartPay {



    function processpayment(){

        $access_code = 'AVXM00JA12AL69MXLA';
        $working_key = '9F29A0F0FAF0DE909CA92171DD96433B';

        $testing_url = 'https://mti.bankmuscat.com:6443/transaction.do?command=initiateTransaction';
        $production_url = 'https://smartpaytrns.bankmuscat.com/transaction.do?command=initiateTransaction';
        $url = $testing_url();

        $data = array(
            'username' => "annonymous",
            'api_key' => urlencode("1234"),
            'images' => array(
                 urlencode(base64_encode('image1')),
                 urlencode(base64_encode('image2'))
            )
        );
        
        $merchant_data = http_build_query($data);

        $encrypted_data=$this->encrypt($merchant_data,$working_key); 

        $ch = curl_init( $url );
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $encrypted_data);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec( $ch );
        echo $response;

    }

    function encrypt($plainText, $key) {
        $method = "AES-256-GCM";
        $initVector = openssl_random_pseudo_bytes(16);
        $openMode = openssl_encrypt( $plainText, $method, $key, OPENSSL_RAW_DATA, $initVector, $tag );
        return bin2hex( $initVector ).bin2hex( $openMode . $tag );
    }
    
    function decrypt($encryptedText, $key) {
        $method = 'AES-256-GCM';
        $encryptedText = hex2bin( $encryptedText );
        $iv_len = $tag_length = 16;
        $iv = substr( $encryptedText, 0, $iv_len );
        $tag = substr( $encryptedText, -$tag_length, $iv_len );
        $ciphertext = substr( $encryptedText, $iv_len, -$tag_length );
        return openssl_decrypt( $ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv, $tag );
    }

}