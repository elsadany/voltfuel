<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class General extends CI_Controller
{


    public function __construct(){
        parent::__construct();
        $this->load->model('general_model');
    }

    public function terms(){
        echo $this->general_model->getterms();
    }

    public function privacy(){
        echo $this->general_model->getprivacypolicy();
    }

}