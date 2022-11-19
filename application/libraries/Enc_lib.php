<?php

class Enc_lib {

    public $pub_key = 'ss@pubkey';
    public $pvt_key = 'ss@pvtkey';
    public $app_pub_key = 'vf@tspico#pubkey_2021';
    public $app_pvt_key = 'vf@tspico#pvtkey_2021';
    public $bnk_key = 'vf@tspico#pvtkey_2021';

    function encrypt($string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $this->pvt_key);
        $iv = substr(hash('sha256', $this->pub_key), 0, 16);
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        return $output;
    }

    function dycrypt($string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $this->pvt_key);
        $iv = substr(hash('sha256', $this->pub_key), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }

    function passHashEnc($password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $hashed_password;
    }

    function passHashDyc($password, $encrypt_password) {
        $isPasswordCorrect = password_verify($password, $encrypt_password);
        return $isPasswordCorrect;
    }

    function bnk_encrypt($plainText, $key) {
        $method = "AES-256-GCM";
        $initVector = openssl_random_pseudo_bytes(16);
        $openMode = openssl_encrypt( $plainText, $method, $key, OPENSSL_RAW_DATA, $initVector, $tag );
        return bin2hex( $initVector ).bin2hex( $openMode . $tag );
    }
    
    function bnk_decrypt($encryptedText, $key) {
        $method = 'AES-256-GCM';
        $encryptedText = hex2bin( $encryptedText );
        $iv_len = $tag_length = 16;
        $iv = substr( $encryptedText, 0, $iv_len );
        $tag = substr( $encryptedText, -$tag_length, $iv_len );
        $ciphertext = substr( $encryptedText, $iv_len, -$tag_length );
        return openssl_decrypt( $ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv, $tag );
    }



}
