<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Payment extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_model');
        $this->load->model('app_model');
        $this->load->model('stations_model');
        $this->load->model("outlets_model");
		$this->load->library('customlib');
		$this->load->library('upload');
        $this->load->model("encryption_model");
        $this->load->library('encoding_lib');
        $this->load->library('enc_lib');
        
    }

    public function index()
    {

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