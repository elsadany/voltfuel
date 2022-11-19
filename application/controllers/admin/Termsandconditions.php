<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} 

class Termsandconditions extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("outlets_model");
        $this->load->model("stations_model");
        $this->load->model("encryption_model");
        $this->load->model("termsandconditions_model");
        $this->load->library('encoding_lib');

    }
    
    public function index(){

        if (!$this->rbac->hasPrivilege('termsandconditions', 'can_view')) {
            access_denied();
        }
        
        $this->session->set_userdata('top_menu', 'Termsandconditions');

        $termsandconditionslist        = $this->termsandconditions_model->termsandconditionslist();
        $data['termsandconditionslist'] = $termsandconditionslist;
        $this->load->view('layout/header', $data);
        $this->load->view('termsandconditions/termsandconditions_head', $data);
        $this->load->view('termsandconditions/termsandconditions', $data);
        $this->load->view('layout/footer', $data);
    }


    public function create(){
        $this->form_validation->set_rules('termsandconditions', 'Terms and Conditions', 'trim|required|xss_clean');     
        if ($this->form_validation->run() == false) {
            $listoutlets         = $this->outlets_model->listoutlets();
            $data['listoutlets'] = $listoutlets;
            $this->load->view('layout/header');
            $this->load->view('termsandconditions/termsandconditions_create', $data);
            $this->load->view('layout/footer');
        }else{

            $data = array(
                'termsandconditions'  => $this->input->post('termsandconditions'), 
            );

            $this->termsandconditions_model->addtermsandconditions($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/termsandconditions/index');
        }
    }

    public function edit($id){

        $data['title']      = 'Edit Terms & Conditions';
        $data['title_list'] = 'Outl';
        $id = $this->enc_lib->dycrypt($id);
        $data['id']         = $id;
        $edittermsandconditions       = $this->termsandconditions_model->get($id);
        $data['edittermsandconditions']   = $edittermsandconditions;
        $this->load->view('layout/header');
        $this->load->view('termsandconditions/termsandconditions_edit', $data);
        $this->load->view('layout/footer');
    }

    public function update(){
        $this->form_validation->set_rules('termsandconditions', 'Terms and Conditions', 'trim|required|xss_clean');     
        if ($this->form_validation->run() == false) {
            $listoutlets         = $this->outlets_model->listoutlets();
            $data['listoutlets'] = $listoutlets;
            $this->load->view('layout/header');
            $this->load->view('termsandconditions/termsandconditions_edit', $data);
            $this->load->view('layout/footer');
        }else{

            $data = array(
                'termsandconditions'  => $this->input->post('termsandconditions'),
                'id'                  => $this->input->post('hid'),
            );

            $this->termsandconditions_model->addtermsandconditions($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/termsandconditions/index');
        }
    }

    public function delete($id){
        $id = $this->enc_lib->dycrypt($id);
        $edittermsandconditions       = $this->termsandconditions_model->deletetermsandconditions($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
        redirect('admin/termsandconditions/index');
    }
}
?>