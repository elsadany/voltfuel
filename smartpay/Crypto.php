<?php
error_reporting(0);

function encrypt($plainText, $key) {
	//echo 'Key: '.$key;
	$method = "aes-256-gcm";
	$initVector = openssl_random_pseudo_bytes(16);
	$openMode = openssl_encrypt( $plainText, $method, $key, OPENSSL_RAW_DATA, $initVector, $tag );
	return bin2hex( $initVector ).bin2hex( $openMode . $tag );
}

function decrypt($encryptedText, $key) {
	
	$method = "aes-256-gcm";
	$encryptedText = hex2bin( $encryptedText );
	//echo 'DKey: '.$encryptedText;
	$iv_len = $tag_length = 16;
	$iv = substr( $encryptedText, 0, $iv_len );
	$tag = substr( $encryptedText, -$tag_length, $iv_len );
	$ciphertext = substr( $encryptedText, $iv_len, -$tag_length );
	return openssl_decrypt( $ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv, $tag );
}
