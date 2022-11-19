<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Pricings extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('setting_model');
        $this->load->model('app_model');
        $this->load->model('pricings_model');
		$this->load->library('customlib');
        $this->load->model("encryption_model");
        $this->load->library('encoding_lib');
    }

    public function index()
    {
        $data = array();
        $data['categories'] = $this->pricings_model->getcategories();
        $data['plans'] = $this->pricings_model->getplans();
        $this->load->view('layout/header', $data);
        $this->load->view('pricings/pricingplanone_list', $data);
        $this->load->view('layout/footer', $data);
        $this->load->view('pricings/pricingplan_scripts', $data);
        $this->load->view('layout/footer-bottom', $data);

    }

    public function list()
    {
        $data = array();
        $data['categories'] = $this->pricings_model->getcategories();
        $data['plans'] = $this->pricings_model->getplans();
        //print_r($data);
        $this->load->view('layout/header', $data);
        $this->load->view('pricings/pricing_list1', $data);
        $this->load->view('layout/footer', $data);

    }

    public function create()
    {
        $data = array();
        $this->load->view('layout/header', $data);
        $this->load->view('pricings/pricing_create', $data);
        $this->load->view('layout/footer', $data);

    }

    public function edit($id)
    {
        $data = array();
        $this->load->view('layout/header', $data);
        $this->load->view('pricings/pricing_edit', $data);
        $this->load->view('layout/footer', $data);

    }

    public function categories(){
        $data = array();
        $data['categories'] = $this->pricings_model->getcategories();
        $this->load->view('layout/header', $data);
        $this->load->view('pricings/pricing_categories', $data);
        $this->load->view('layout/footer', $data);
    }

    public function addcategory(){
        $this->form_validation->set_rules('category_name', 'Please Enter Station ID', 'trim|required|xss_clean');
        //$this->form_validation->set_rules('purchasedate', 'Date of Purchase', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">' . $this->lang->line('error_message') . '</div>');
            redirect('admin/pricings/categories');
        }else{
            $data = array(
                'category'  => $this->input->post('category_name'),
            );
            $this->pricings_model->addcategory($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/pricings/categories');
        }
    }

    public function editcategory(){
        if (!$this->rbac->hasPrivilege('books', 'can_edit')) {
            access_denied();
        }

        $this->form_validation->set_rules('category_name', 'Please Enter Station ID', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">' . $this->lang->line('error_message') . '</div>');
            redirect('admin/pricings/categories');
        }else{
            $data = array(
                'id'  => $this->input->post('category_id'),
                'category'  => $this->input->post('category_name'),
            );
            $this->pricings_model->addcategory($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/pricings/categories');
        }
    }

    public function deletecategory($id){
        
    }

    public function addplan(){
        $this->form_validation->set_rules('planname', 'Please Enter Valid Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('planamount', 'Please Enter Valid Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('plantype', 'Please Select Valid Type', 'trim|required|xss_clean');
        $this->form_validation->set_rules('planswaps', 'Please Enter Plan Swaps', 'trim|required|xss_clean');
        $this->form_validation->set_rules('maxrental', 'Please Enter Max Rent', 'trim|required|xss_clean');
        $this->form_validation->set_rules('holdamount', 'Please Enter Hold Amount ', 'trim|required|xss_clean');        
        $this->form_validation->set_rules('validmonths', 'Please Enter Valid Months', 'trim|required|xss_clean'); 
        $this->form_validation->set_rules('paymentmode', 'Please Select Payment Mode', 'trim|required|xss_clean');      
        $this->form_validation->set_rules('penaltyamount', 'Please Enter Penalty Amount', 'trim|required|xss_clean');                       
        //$this->form_validation->set_rules('purchasedate', 'Date of Purchase', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">' . $this->lang->line('error_message') . '</div>');
            redirect('admin/pricings');
        }else{

            $data = array(
                'plan_name'  => $this->input->post('planname'),
                'plan_amount'  => $this->input->post('planamount'),
                'plan_type'  => $this->input->post('plantype'),
                'no_of_swaps'  => $this->input->post('planswaps'),
                'max_rental_period'  => $this->input->post('maxrental'),
                'plan_categoryid'  => $this->input->post('plancategory'),
                'payment_mode_id'  => $this->input->post('paymentmode'),
                'plan_description'  => $this->input->post('plandescription'),
                'validity_months'  => $this->input->post('validmonths'),
                'max_charges' => $this->input->post('holdamount'),
                'penalty_amount' => $this->input->post('penaltyamount'),
            );
            $this->pricings_model->addplan($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/pricings');
        }
    }

    public function updateplan($planid=null){
        $this->form_validation->set_rules('planname', 'Please Enter Valid Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('planamount', 'Please Enter Valid Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('plantype', 'Please Enter Valid Amount', 'trim|required|xss_clean');
        $this->form_validation->set_rules('planswaps', 'Please Enter Plan Swaps', 'trim|required|xss_clean');
        $this->form_validation->set_rules('maxrental', 'Please Enter Max Rent', 'trim|required|xss_clean');
        $this->form_validation->set_rules('holdamount', 'Please Enter Hold Amount ', 'trim|required|xss_clean');        
        $this->form_validation->set_rules('validmonths', 'Please Enter Valid Months', 'trim|required|xss_clean'); 
        $this->form_validation->set_rules('paymentmode', 'Please Select Payment Mode', 'trim|required|xss_clean');      
        $this->form_validation->set_rules('penaltyamount', 'Please Enter Penalty Amount', 'trim|required|xss_clean');          
        //$this->form_validation->set_rules('purchasedate', 'Date of Purchase', 'trim|required|xss_clean');
        if ($this->form_validation->run() == false) {
            //echo "validation Error";
            $this->session->set_flashdata('msg', '<div class="alert alert-danger text-left">' . $this->lang->line('error_message') . '</div>');
            redirect('admin/pricings');
        }else{
            //echo "validation successfully";
            $data = array(
                'id'=>$this->input->post('plan_id'),
                'plan_name'  => $this->input->post('planname'),
                'plan_amount'  => $this->input->post('planamount'),
                'plan_type'  => $this->input->post('plantype'),
                'no_of_swaps'  => $this->input->post('planswaps'),
                'max_rental_period'  => $this->input->post('maxrental'),
                'plan_categoryid'  => $this->input->post('plancategory'),
                'payment_mode_id'  => $this->input->post('paymentmode'),
                'plan_description'  => $this->input->post('plandescription'),
                'validity_months'  => $this->input->post('validmonths'),
                'max_charges' => $this->input->post('holdamount'),
                'penalty_amount' => $this->input->post('penaltyamount'),penaltyamount
            );
           // print_r($data);
            $this->pricings_model->addplan($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/pricings');
        }
    }


    public function getplan($planid=null){

        echo json_encode($this->pricings_model->getplans($planid));
    }

    public function deleteplan($planid){
        $planid = $this->enc_lib->dycrypt($planid);
        $status = $this->pricings_model->deleteplan($planid);
        $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('delete_message') . '</div>');

        redirect('admin/pricings');

    }

    public function makepricingactive()
    {
        $id=$this->input->post('id');
        $data['success']=$this->pricings_model->makepricingactive($id);
        echo json_encode($data);
    }

    public function makepricinginactive()
    {
        $id=$this->input->post('id');
        $data['success']=$this->pricings_model->makepricinginactive($id);
        echo json_encode($data);
    }

    public function pricingplanone()
    {
        $data = array();
        $data['categories'] = $this->pricings_model->getcategories();
        $data['plans'] = $this->pricings_model->getplans();
        $this->load->view('layout/header', $data);
        $this->load->view('pricings/pricingplanone_list', $data);
        $this->load->view('layout/footer', $data);
        $this->load->view('pricings/pricingplan_scripts', $data);
        $this->load->view('layout/footer-bottom', $data);
    }

    public function getplandetails($planid=null){
        echo json_encode($this->pricings_model->getplandetails($planid));
    }
}