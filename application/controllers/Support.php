<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Support extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        
        $data['title'] = 'VoltaFuel Customer Support';
        $this->load->view('layout/support/header', $data);
        $this->load->view('support/support-landing', $data);
        $this->load->view('support/support-modals', $data);
        $this->load->view('layout/support/footer', $data);
    }

}