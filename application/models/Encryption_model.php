<?php


class Encryption_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('Enc_lib');

    }

    public function encrypt($string){
        return $this->Enc_lib->encrypt($string);
    }
}