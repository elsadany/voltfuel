<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} 

class Outlets extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("outlets_model");
        $this->load->model("encryption_model");
        $this->load->model('filetype_model');
        $this->load->library('encoding_lib');

    }



    // public function index(){

    //     if (!$this->rbac->hasPrivilege('outlets', 'can_view')) {
    //         access_denied();
    //     }

    //     //$this->session->set_userdata('top_menu', 'Outlets');
    //     //$this->session->set_userdata('sub_menu', 'exam/index'
        
    //     // $data['title'] = 'VoltaFuel Admin - Manage Outlets';
    //     // $data['title_list'] = 'Outlets List';
    //     // $data['listview'] = '';
    //     // $data['gridview'] = 'active';
    //     // $listoutlets         = $this->outlets_model->listoutlets();
    //     // $data['listoutlets'] = $listoutlets;
    //     // $this->load->view('layout/header', $data);
    //     // $this->load->view('outlets/outlets_head', $data);
    //     // $this->load->view('outlets/outlets', $data);
    //     // $this->load->view('outlets/outlets_modals', $data);
    //     // $this->load->view('layout/footer', $data);
    // }


    public function index()
    {
        if (!$this->rbac->hasPrivilege('outlets', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Outlets');
        //$this->session->set_userdata('sub_menu', 'exam/index');
        $data['title'] = 'VoltaFuel Admin - Manage Outlets';
        $data['listview'] = 'active';
        $data['gridview'] = '';
        $listoutlets         = $this->outlets_model->listoutlets();
        $data['listoutlets'] = $listoutlets;
        $this->load->view('layout/header', $data);
        $this->load->view('outlets/outlets_head', $data);
        $this->load->view('outlets/outlets_list', $data);
        $this->load->view('outlets/outlets_modals', $data);
        $this->load->view('layout/footer', $data);
        $this->load->view('outlets/outlets_scripts', $data);
        $this->load->view('layout/footer-bottom', $data);

    }

    // public function list(){
    //     $this->session->set_userdata('top_menu', 'Outlets');
    //     //$this->session->set_userdata('sub_menu', 'exam/index');
    //     $data['title'] = 'VoltaFuel Admin - Manage Outlets';
    //     $data['listview'] = 'active';
    //     $data['gridview'] = '';
    //     $listoutlets         = $this->outlets_model->listoutlets();
    //     $data['listoutlets'] = $listoutlets;
    //     $this->load->view('layout/header', $data);
    //     $this->load->view('outlets/outlets_head', $data);
    //     $this->load->view('outlets/outlets_list', $data);
    //     $this->load->view('outlets/outlets_modals', $data);
    //     $this->load->view('layout/footer', $data);
    //     $this->load->view('outlets/outlets_scripts', $data);
    //     $this->load->view('layout/footer-bottom', $data);
    // }


    public function view($outletid)
    {

        $data['title']      = 'Outlet View';
        $data['title_list'] = 'Outlets List';
        $id = $this->enc_lib->dycrypt($outletid);
        $data['id']         = $id;
        $editoutlet          = $this->outlets_model->get($id);
        $data['viewoutlet']   = $editoutlet;
        $this->load->view('layout/header');
        $this->load->view('outlets/outlets_view', $data);
        $this->load->view('layout/footer');
        $this->load->view('outlets/outlets_scripts', $data);
        $this->load->view('layout/footer-bottom', $data);
    }

    public function getoutlets(){
        $filter = $this->input->post('outletstatus');
        $listoutlets        = $this->outlets_model->filterlistoutlets($filter);
        $data['listoutlets'] = $listoutlets;
        $html="";
        if (isset($listoutlets)){
            $html .= "<table class='table table-striped custom-table datatable'>";
            $html .= "<thead>
                        <tr>
                        <th>S.No</th>
                        <th>Outlet Name</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Operation Mode</th>
                        <th>Support</th>
                        <th>Images</th>
                        <th>Status</th>
                        <th>Action</th>
                        </tr>
                      </thead>";
            $html .= "<tbody>";
            $i=1;
            foreach($listoutlets as $outlets){
                $html .= "<tr>";
                $html .= "<td>".$i."</td>";
                $html .= "<td><a href='".base_url()."admin/outlets/view/" .$this->enc_lib->encrypt($outlets['id'])."' class='text-primary'>".$outlets['outlet_name']."</a></td>";
                $html .= "<td>".$outlets['address']."</td>";
                $html .= "<td>".$outlets['city']."</td>";
                $html .= "<td>".$outlets['operation_mode']."<br>".$outlets['operation_time']."</td>";
                $html .= "<td>".$outlets['support']."</td>";
                $html .= "<td>
                                <ul class='team-members text-nowrap'>
                                    <li>
                                        <a href='#' title='Img-1' data-bs-toggle='tooltip'><img alt='' src='" .base_url(). "/uploads/outlets/images/".$outlets['id']."/".$outlets['image1']."'></a>
                                    </li>
                                    <li>
                                        <a href='#' title='Img-2' data-bs-toggle='tooltip'><img alt='' src='".base_url()."/uploads/outlets/images/".$outlets['id']."/".$outlets['image2']."'></a>
                                    </li>
                                    <li>
                                        <a href='#' title='Img-3' data-bs-toggle='tooltip'><img alt='' src='".base_url()."/uploads/outlets/images/".$outlets['id']."/".$outlets['image3']."'></a>
                                    </li>
                                    <li>
                                        <a href='#' title='Img-4' data-bs-toggle='tooltip'><img alt='' src='".base_url()."/uploads/outlets/images/".$outlets['id']."/".$outlets['image4']."'></a>
                                    </li>
                                </ul> 
                          </td>";
                $html .= "<td>
                            <div class='dropdown action-label' id='outletsactive". $outlets['id'] . "'>";
                                if ($outlets['is_active'] == 'yes')
                                {
                                    $html.="<a href='' class='btn btn-white btn-sm btn-rounded dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-dot-circle-o text-success'></i> Active </a>";
                                }
                                else
                                {
                                    $html.="<a href='' class='btn btn-white btn-sm btn-rounded dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-dot-circle-o text-danger'></i> Inactive </a>";
                                }
                                $html.="<div class='dropdown-menu'>
                                    <a class='dropdown-item'  onclick=makeoutletactive(". $outlets['id'] .")><i class='fa fa-dot-circle-o text-success'></i> Active</a>
                                    <a class='dropdown-item' onclick=makeoutletinactive(". $outlets['id'] .")><i class='fa fa-dot-circle-o text-danger'></i> Inactive</a>
                                </div>
                            </div>
                          </td>";                
                $html .= "<td class='text-end'>
                            <div class='dropdown dropdown-action'>
                                <a href='#' class='action-icon dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'><i class='material-icons'>more_vert</i></a>
                                <div class='dropdown-menu dropdown-menu-right'>
                                    <a class='dropdown-item' href='" . base_url() ."admin/outlets/edit/" .$this->enc_lib->encrypt($outlets['id'])."'><i class='fa fa-pencil m-r-5'></i> Edit</a>
                                    <a class='dropdown-item' href='" . base_url() ."admin/stations/delete/" .$this->enc_lib->encrypt($outlets['id'])."'><i class='fa fa-trash-o m-r-5'></i> Delete</a>
                                </div>
                            </div>
                          </td>";
                $i++;
            }

            $html .= "</tbody>";

        }else{
            $html = "<div id = 'msg' class='error_message'>No Records Found</div>";
        }     
        echo $html;

    }

    public function create(){
        $this->form_validation->set_rules('outlet_name', 'Please Enter Outlet Name', 'trim|required|xss_clean');
        $this->form_validation->set_rules('address', 'Please Enter Address Line', 'trim|required|xss_clean');
        $this->form_validation->set_rules('state_province', 'Please Enter State/Province', 'trim|required|xss_clean');
        $this->form_validation->set_rules('zipcode', 'Please Enter Zipcode', 'trim|required|xss_clean');
        $this->form_validation->set_rules('city', 'Please Enter City', 'trim|required|xss_clean');
        $this->form_validation->set_rules('img_file1', 'Please, Image File-1 Upload', 'callback_handle_upload_image1');     
        $this->form_validation->set_rules('img_file2', 'Please, Image File-2 Upload', 'callback_handle_upload_image2');  
        $this->form_validation->set_rules('img_file3', 'Please, Image File-3 Upload', 'callback_handle_upload_image3');  
        $this->form_validation->set_rules('img_file4', 'Please, Image File-4 Upload', 'callback_handle_upload_image4');     
        if ($this->form_validation->run() == false) {
            $listoutlets         = $this->outlets_model->listoutlets();
            $data['listoutlets'] = $listoutlets;
            $this->load->view('layout/header');
            $this->load->view('outlets/outlets_create', $data);
            $this->load->view('layout/footer');
        }else{

            $data = array(
                'outlet_name'  => $this->input->post('outlet_name'),
                'address'  => $this->input->post('address'),
                'geo_coordinates' => $this->input->post('geo_coordinates'),
                'lat' => $this->input->post('lat'),
                'lng' => $this->input->post('lng'),
            );

            // if (isset($_POST['postdate']) && $_POST['postdate'] != '') {
            //     $data['postdate'] = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('postdate')));
            // } else {
            //     $data['postdate'] = null;
            // }
            $this->outlets_model->addoutlet($data);

        
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            redirect('admin/outlets/index');
        }
    }

    public function handle_upload_image1()
    {
        $image_validate = $this->config->item('image_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type = $_FILES["file"]['type'];
            $file_size = $_FILES["file"]["size"];
            $file_name = $_FILES["file"]["name"];

            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->image_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->image_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = @getimagesize($_FILES['file']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }

                if ($file_size > $result->image_size) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }  

    public function handle_upload_image2()
    {
        $image_validate = $this->config->item('image_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type = $_FILES["file"]['type'];
            $file_size = $_FILES["file"]["size"];
            $file_name = $_FILES["file"]["name"];

            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->image_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->image_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = @getimagesize($_FILES['file']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }

                if ($file_size > $result->image_size) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }  

    public function handle_upload_image3()
    {
        $image_validate = $this->config->item('image_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type = $_FILES["file"]['type'];
            $file_size = $_FILES["file"]["size"];
            $file_name = $_FILES["file"]["name"];

            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->image_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->image_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = @getimagesize($_FILES['file']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }

                if ($file_size > $result->image_size) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }  

    public function handle_upload_image4()
    {
        $image_validate = $this->config->item('image_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            $file_type = $_FILES["file"]['type'];
            $file_size = $_FILES["file"]["size"];
            $file_name = $_FILES["file"]["name"];

            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->image_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->image_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = @getimagesize($_FILES['file']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                    return false;
                }

                if ($file_size > $result->image_size) {
                    $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }  


    public function update()
    {
         $this->form_validation->set_rules('outlet_name', 'Outlet Name', 'trim|required');
         $this->form_validation->set_rules('upfile1', 'Image File-1', 'callback_handle_upload_upimage1');     
         $this->form_validation->set_rules('upfile2', 'Image File-2', 'callback_handle_upload_upimage2');  
         $this->form_validation->set_rules('upfile3', 'Image File-3', 'callback_handle_upload_upimage3');  
         $this->form_validation->set_rules('upfile4', 'Image File-4', 'callback_handle_upload_upimage4');  
         $data_doc1='';  
         $data_doc2=''; 
         $data_doc3=''; 
         $data_doc4=''; 
        if ($this->form_validation->run() == false) {
            $listoutlets         = $this->outlets_model->listoutlets();
            $data['listoutlets'] = $listoutlets;
            $this->load->view('layout/header');
            $this->load->view('outlets/outlets_edit', $data);
            $this->load->view('layout/footer');
        } else {            
            $id              = $this->input->post('id');
            $outlet_name     = $this->input->post('outlet_name');
            $geo_coordinates = $this->input->post('geo_coordinates');
            $lat             = $this->input->post('lat');
            $lng             = $this->input->post('lng');
            $operation_mode  = $this->input->post('operation_mode');
            $operation_time  = $this->input->post('operation_time');
            $support         = $this->input->post('support');
            $address         = $this->input->post('address');
            $city            = $this->input->post('city');
            $province        = $this->input->post('province');
            $pincode         = $this->input->post('pincode');

            $oldimgfile1     = $this->input->post('old_imgfile1');
            $imgfile1        = $this->input->post('upfile1');         
            $oldimgfile2     = $this->input->post('old_imgfile2');
            $imgfile2        = $this->input->post('upfile2'); 
            $oldimgfile3     = $this->input->post('old_imgfile3');
            $imgfile3        = $this->input->post('upfile3'); 
            $oldimgfile4     = $this->input->post('old_imgfile4');
            $imgfile4        = $this->input->post('upfile4');  
            

            $task_id  = $id;
            if (isset($_FILES["upfile1"]) && !empty($_FILES['upfile1']['name'])) {
                $oldfile_path='./uploads/outlets/images/'. $task_id .'/' . $oldimgfile1;
                if(is_file($oldfile_path))
                {
                    unlink($oldfile_path);
                }

                $uploaddir = './uploads/outlets/images/'. $task_id .'/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder". $uploaddir);
                }
                $fileInfo    = pathinfo($_FILES["upfile1"]["name"]);
                $img_name    = $fileInfo['filename'] . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["upfile1"]["tmp_name"], $uploaddir.$img_name);
                $data_doc1 = $img_name;
            }
            else{
                $data_doc1 = $oldimgfile1;
            }

            if (isset($_FILES["upfile2"]) && !empty($_FILES['upfile2']['name'])) {

                $oldfile_path='./uploads/outlets/images/'. $task_id .'/' . $oldimgfile2;
                if(is_file($oldfile_path))
                {
                    unlink($oldfile_path);
                }

                $uploaddir = './uploads/outlets/images/'. $task_id .'/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder". $uploaddir);
                }
                $fileInfo    = pathinfo($_FILES["upfile2"]["name"]);
                $img_name    =  $fileInfo['filename'] . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["upfile2"]["tmp_name"], $uploaddir.$img_name);
                $data_doc2 = $img_name;
            }
            else{
                $data_doc2 = $oldimgfile2;
            }

            if (isset($_FILES["upfile3"]) && !empty($_FILES['upfile3']['name'])) {

                $oldfile_path='./uploads/outlets/images/'. $task_id .'/' . $oldimgfile3;
                if(is_file($oldfile_path))
                {
                    unlink($oldfile_path);
                }

                $uploaddir = './uploads/outlets/images/'. $task_id .'/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder". $uploaddir);
                }
                $fileInfo    = pathinfo($_FILES["upfile3"]["name"]);
                $img_name    =  $fileInfo['filename'] . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["upfile3"]["tmp_name"], $uploaddir.$img_name);
                $data_doc3 = $img_name;
            }
            else{
                $data_doc3 = $oldimgfile3;
            }

            if (isset($_FILES["upfile4"]) && !empty($_FILES['upfile4']['name'])) {

                $oldfile_path='./uploads/outlets/images/'. $task_id .'/' . $oldimgfile4;
                if(is_file($oldfile_path))
                {
                    unlink($oldfile_path);
                }

                $uploaddir = './uploads/outlets/images/'. $task_id .'/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder". $uploaddir);
                }
                $fileInfo    = pathinfo($_FILES["upfile4"]["name"]);
                $img_name    =  $fileInfo['filename'] . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["upfile4"]["tmp_name"], $uploaddir.$img_name);
                $data_doc4 = $img_name;
            }   
            else{
                $data_doc4 = $oldimgfile4;
            }                     

                $data = array(
                    'id'              => $id,
                    'outlet_name'     => $outlet_name,
                    'geo_coordinates' => $geo_coordinates,
                    'lat'             => $lat,
                    'lng'             => $lng,
                    'operation_mode'  => $operation_mode,
                    'operation_time'  => $operation_time,
                    'support'         => $support,
                    'address'         => $address,
                    'city'            => $city,
                    'province'        => $province,
                    'pincode'         => $pincode,
                    'image1'          => $data_doc1,
                    'image2'          => $data_doc2,
                    'image3'          => $data_doc3,
                    'image4'          => $data_doc4,
                );

            print_r($data);
            $this->outlets_model->addoutlet($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/outlets');
       }
    }



    public function handle_upload_upimage1()
    {
        $image_validate = $this->config->item('image_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["upfile1"]) && !empty($_FILES['upfile1']['name'])) {
           
            $file_type = $_FILES["upfile1"]['type'];
            $file_size = $_FILES["upfile1"]["size"];
            $file_name = $_FILES["upfile1"]["name"];
            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->image_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->image_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = @getimagesize($_FILES['upfile1']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_upimage1', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_upimage1', $this->lang->line('file_type_not_allowed'));
                    return false;
                }

                if ($file_size > $result->image_size) {
                    $this->form_validation->set_message('handle_upload_upimage1', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload_upimage1', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }  

    public function handle_upload_upimage2()
    {
        //$image_validate = $this->config->item('image_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["upfile2"]) && !empty($_FILES['upfile2']['name'])) {

            $file_type = $_FILES["upfile2"]['type'];
            $file_size = $_FILES["upfile2"]["size"];
            $file_name = $_FILES["upfile2"]["name"];

            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->image_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->image_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = @getimagesize($_FILES['upfile2']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_upimage2', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_upimage2', $this->lang->line('file_type_not_allowed'));
                    return false;
                }

                if ($file_size > $result->image_size) {
                    $this->form_validation->set_message('handle_upload_upimage2', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload_upimage2', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }  

    public function handle_upload_upimage3()
    {
        $image_validate = $this->config->item('image_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["upfile3"]) && !empty($_FILES['upfile3']['name'])) {

            $file_type = $_FILES["upfile3"]['type'];
            $file_size = $_FILES["upfile3"]["size"];
            $file_name = $_FILES["upfile3"]["name"];

            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->image_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->image_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = @getimagesize($_FILES['upfile3']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_upimage3', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_upimage3', $this->lang->line('file_type_not_allowed'));
                    return false;
                }

                if ($file_size > $result->image_size) {
                    $this->form_validation->set_message('handle_upload_upimage3', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload_upimage3', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }  

    public function handle_upload_upimage4()
    {
        //$image_validate = $this->config->item('image_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["upfile4"]) && !empty($_FILES['upfile4']['name'])) {

            $file_type = $_FILES["upfile4"]['type'];
            $file_size = $_FILES["upfile4"]["size"];
            $file_name = $_FILES["upfile4"]["name"];

            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->image_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->image_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = @getimagesize($_FILES['upfile4']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_upimage4', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_upimage4', $this->lang->line('file_type_not_allowed'));
                    return false;
                }

                if ($file_size > $result->image_size) {
                    $this->form_validation->set_message('handle_upload_upimage4', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload_upimage4', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }     

    public function edit($id){
        if (!$this->rbac->hasPrivilege('books', 'can_edit')) {
            access_denied();
        }

        $data['title']      = 'Edit Outlet';
        $data['title_list'] = 'Outlets List';
        $id = $this->enc_lib->dycrypt($id);
        $data['id']         = $id;
        $editoutlet          = $this->outlets_model->get($id);
        $data['editoutlet']   = $editoutlet;
        $this->load->view('layout/header');
        $this->load->view('outlets/outlets_edit', $data);
        $this->load->view('layout/footer');
    }


    public function makeoutletactive()
    {
        $id=$this->input->post('id');
        $data['success']=$this->outlets_model->makeoutletactive($id);
        echo json_encode($data);
    }

    public function makeoutletinactive()
    {
        $id=$this->input->post('id');
        $data['success']=$this->outlets_model->makeoutletinactive($id);
        echo json_encode($data);
    }

    public function delete($outlet_id){

    }


}