<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class General_model extends MY_Model {

    public function __construct() {
        parent::__construct();

    }

    public function getterms(){
        return $this->db->select('termsandconditions')->from('termsandconditions')->limit(1)->get()->row('termsandconditions');
    }

    public function getprivacypolicy(){
        return $this->db->select('privacypolicy')->from('privacypolicy')->limit(1)->get()->row('privacypolicy');
    }
}