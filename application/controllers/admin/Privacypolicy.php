<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} 

class Privacypolicy extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("outlets_model");
        $this->load->model("stations_model");
        $this->load->model("encryption_model");
        $this->load->model("privacypolicy_model");
        $this->load->library('encoding_lib');

    }
    
    public function index(){

        if (!$this->rbac->hasPrivilege('privacypolicy', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'privacypolicy');
    
        $privacypolicylist        = $this->privacypolicy_model->privacypolicylist();
        $data['privacypolicylist'] = $privacypolicylist;
        $this->load->view('layout/header', $data);
        $this->load->view('privacypolicy/privacypolicy_head', $data);
        $this->load->view('privacypolicy/privacypolicy', $data);
        $this->load->view('layout/footer', $data);
    }


    public function create(){
        $this->form_validation->set_rules('privacypolicy', 'Privacy Policy', 'trim|required|xss_clean');     
        if ($this->form_validation->run() == false) {
            $listoutlets         = $this->outlets_model->listoutlets();
            $data['listoutlets'] = $listoutlets;
            $this->load->view('layout/header');
            $this->load->view('privacypolicy/privacypolicy_create', $data);
            $this->load->view('layout/footer');
        }else{

            $data = array(
                'privacypolicy'  => $this->input->post('privacypolicy'), 
            );

            $this->privacypolicy_model->addprivacypolicy($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/privacypolicy/index');
        }
    }

    public function edit($id){

        $id = $this->enc_lib->dycrypt($id);
        $data['id']         = $id;
        $editprivacypolicy      = $this->privacypolicy_model->get($id);
        $data['editprivacypolicy']   = $editprivacypolicy;
        $this->load->view('layout/header');
        $this->load->view('privacypolicy/privacypolicy_edit', $data);
        $this->load->view('layout/footer');
    }

    public function update(){
        $this->form_validation->set_rules('privacypolicy', 'Privacy Policy', 'trim|required|xss_clean');     
        if ($this->form_validation->run() == false) {
            $listoutlets         = $this->outlets_model->listoutlets();
            $data['listoutlets'] = $listoutlets;
            $this->load->view('layout/header');
            $this->load->view('privacypolicy/privacypolicy_edit', $data);
            $this->load->view('layout/footer');
        }else{

            $data = array(
                'privacypolicy'  => $this->input->post('privacypolicy'),
                'id'                  => $this->input->post('hid'),
            );

            $this->privacypolicy_model->addprivacypolicy($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/privacypolicy/index');
        }
    }

    public function delete($id){
        $id = $this->enc_lib->dycrypt($id);
        $this->privacypolicy_model->deleteprivacypolicy($id);
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
        redirect('admin/privacypolicy/index');
    }
}
?>