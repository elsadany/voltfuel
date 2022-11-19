<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
} 

class Stations extends Admin_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("outlets_model");
        $this->load->model("stations_model");
        $this->load->model("encryption_model");
        $this->load->library('encoding_lib');

    }



    public function index(){

        if (!$this->rbac->hasPrivilege('stations', 'can_view')) {
            access_denied();
        }

        $this->session->set_userdata('top_menu', 'Stations');
        //$this->session->set_userdata('sub_menu', 'exam/index'
        
        $data['title'] = 'VoltaFuel Admin - Manage Stations';
        $data['title_list'] = 'Stations List';
        $data['listview'] = '';
        $data['gridview'] = 'active';
        $this->checkdevices();
        $liststations         = $this->stations_model->getstations();
        $data['liststations'] = $liststations;
        $this->load->view('layout/header', $data);
        $this->load->view('stations/stations_head', $data);
        $this->load->view('stations/stations', $data);
        $this->load->view('layout/footer', $data);
        $this->load->view('stations/stations_scripts',$data);
    }


    public function create($id=null){
        $this->session->set_userdata('top_menu', 'Devices');
        //$this->session->set_userdata('sub_menu', 'exam/index');
        $data['title'] = 'VoltaFuel Admin - Create Station';
        $listoutlets         = $this->outlets_model->listoutlets();
        $data['listoutlets'] = $listoutlets;
        $this->load->view('layout/header', $data);
        $this->load->view('stations/stations_create', $data);
        $this->load->view('layout/footer', $data);
        $this->load->view('stations/stations_scripts',$data);
    }

    
    public function view($deviceid){
        //echo $deviceid;
         $this->session->set_userdata('top_menu', 'Devices');
        // //$this->session->set_userdata('sub_menu', 'exam/index');
        $data['title'] = 'VoltaFuel Admin - View Station';
        $data['deviceid'] = $deviceid;
        $data['batterieslist'] = $this->checkbatteries($deviceid);

        $this->load->view('layout/header', $data);
        $this->load->view('stations/stations_view', $data);
        $this->load->view('layout/footer', $data);
        $this->load->view('stations/stations_scripts',$data);
        $this->load->view('layout/footer-bottom',$data);
   
    }

    public function edit($id){
        if (!$this->rbac->hasPrivilege('books', 'can_edit')) {
            access_denied();
        }

        $data['title']      = 'Edit Station';
        $data['title_list'] = 'Stations List';
        $id = $this->enc_lib->dycrypt($id);
        $data['id']         = $id;
        $editstation          = $this->stations_model->get($id);
        $data['editstation']   = $editstation;
        $listoutlets         = $this->outlets_model->listoutlets();
        $data['listoutlets'] = $listoutlets;
        $this->load->view('layout/header');
        $this->load->view('stations/stations_edit', $data);
        $this->load->view('layout/footer');
        $this->load->view('stations/stations_scripts',$data);
        $this->load->view('layout/footer-bottom',$data);

    }

    public function delete($outlet_id){

    }

    public function insert(){
        $this->form_validation->set_rules('station_id', 'Please Enter Station ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('station_name', 'Station Name', 'trim|required|is_unique[stations.station_name]');
        $this->form_validation->set_rules('qr_code', 'Please Enter QR Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('manufacturer', 'Please Enter Manufacturer', 'trim|required|xss_clean');
        $this->form_validation->set_rules('batteries', 'Please Enter No of Batteries on Station', 'trim|required|xss_clean');
        $this->form_validation->set_rules('upfile', 'Upload File', 'callback_handle_upload_addimage');
        //$this->form_validation->set_rules('purchasedate', 'Date of Purchase', 'trim|required|xss_clean');
        $data_img = '';  
        if ($this->form_validation->run() == false) {
            $listoutlets         = $this->outlets_model->listoutlets();
            $data['listoutlets'] = $listoutlets;
            $this->load->view('layout/header');
            $this->load->view('stations/stations_create', $data);
            $this->load->view('layout/footer');
        }else{
            $station_name  = $this->input->post('station_name');
            $station_id    = $this->input->post('station_id');
            $batteries     = $this->input->post('batteries');
            $qr_code       = $this->input->post('qr_code');
            $station_type  = $this->input->post('station_type');
            $manufacturer  = $this->input->post('manufacturer');
            $purchasedate  = $this->input->post('purchasedate');
            $outlet_name   = $this->input->post('outlet_name');
            $is_active     = $this->input->post('enabled');

            $data = array(
                'station_name' => $station_name,
                'station_id'  => $station_id,
                'batteries'  => $batteries,
                'qr_code' => $qr_code,
                'station_type' => $station_type,
                'manufacturer' => $manufacturer,
                'purchasedate' => $purchasedate,
                'outlet_id' => $outlet_name,
                'is_active' => $enabled,
            );
            $insert   = true;
            if($insert)
            {
                $insert_id =  $this->stations_model->addstation($data);
                echo $insert_id;
                $st_id     = $insert_id;

                if (isset($_FILES["upfile"]) && !empty($_FILES['upfile']['name'])) {
    
                    $uploaddir = './uploads/stations/images/'. $st_id .'/';
                    if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                        die("Error creating folder". $uploaddir);
                    }
                    $fileInfo    = pathinfo($_FILES["upfile"]["name"]);
                    $img_name    = $fileInfo['filename'] . '.' . $fileInfo['extension'];
                    move_uploaded_file($_FILES["upfile"]["tmp_name"], $uploaddir.$img_name);
                    $data_img = array('id'=>$st_id,'station_image' => $img_name);
                    $this->stations_model->addstation($data_img);
                }   
                $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
                redirect('admin/stations');
            }
            // // if (isset($_POST['postdate']) && $_POST['postdate'] != '') {
            // //     $data['postdate'] = date('Y-m-d', $this->customlib->datetostrtotime($this->input->post('postdate')));
            // // } else {
            // //     $data['postdate'] = null;
            // // }
        
            // $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('success_message') . '</div>');
            // redirect('admin/stations');
        }
    }

    public function handle_upload_addimage()
    {
        $image_validate = $this->config->item('image_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["upfile"]) && !empty($_FILES['upfile']['name'])) {
           
            $file_type = $_FILES["upfile"]['type'];
            $file_size = $_FILES["upfile"]["size"];
            $file_name = $_FILES["upfile"]["name"];
            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->image_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->image_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = @getimagesize($_FILES['upfile']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_addimage', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_addimage', $this->lang->line('file_type_not_allowed'));
                    return false;
                }

                if ($file_size > $result->image_size) {
                    $this->form_validation->set_message('handle_upload_addimage', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload_addimage', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    }     

    public function update()
    {
        $this->form_validation->set_rules('station_id', 'Please Enter Station ID', 'trim|required|xss_clean');
        $this->form_validation->set_rules('station_name', 'Station Name', 'trim|required');
        $this->form_validation->set_rules('qr_code', 'Please Enter QR Code', 'trim|required|xss_clean');
        $this->form_validation->set_rules('manufacturer', 'Please Enter Manufacturer', 'trim|required|xss_clean');
        $this->form_validation->set_rules('batteries', 'Please Enter No of Batteries on Station', 'trim|required|xss_clean');
        $this->form_validation->set_rules('upfile', 'Upload File', 'callback_handle_upload_upimage');
        $data_doc='';
        if ($this->form_validation->run() == false) {
            $id            = $this->input->post('id');
            $editstation          = $this->stations_model->get($id);
            $data['editstation']   = $editstation;
            $this->load->view('layout/header');
            $this->load->view('stations/stations_edit', $data);
            $this->load->view('layout/footer');
        } else {
            $station_name  = $this->input->post('station_name');
            $station_id    = $this->input->post('station_id');
            $batteries     = $this->input->post('batteries');
            $qr_code       = $this->input->post('qr_code');
            $station_type  = $this->input->post('station_type');
            $manufacturer  = $this->input->post('manufacturer');
            $purchasedate  = $this->input->post('purchasedate');
            $outlet_name   = $this->input->post('outlet_name');
            $is_active     = $this->input->post('enabled');
            $id            = $this->input->post('id');

             $oldimgfile    = $this->input->post('oldfile');

            $st_id    = $id;

            if (isset($_FILES["upfile"]) && !empty($_FILES['upfile']['name'])) {

                if(!empty($oldimgfile))
                {
                    $oldfile_path='./uploads/stations/images/'. $st_id .'/' . $oldimgfile;
                    if(is_file($oldfile_path))
                    {
                        unlink($oldfile_path);
                    }
                }

                $uploaddir = './uploads/stations/images/'. $st_id .'/';
                if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                    die("Error creating folder". $uploaddir);
                }
                $fileInfo    = pathinfo($_FILES["upfile"]["name"]);
                $img_name    = $fileInfo['filename'] . '.' . $fileInfo['extension'];
                move_uploaded_file($_FILES["upfile"]["tmp_name"], $uploaddir.$img_name);
                $data_doc = $img_name;
            }
            else
            {
                $data_doc = $oldimgfile;
            }

            $data = array(
                'id'           =>  $id,
                'station_name' => $station_name,
                'station_id'   => $station_id,
                'batteries'    => $batteries,
                'qr_code'      => $qr_code,
                'station_type' => $station_type,
                'manufacturer' => $manufacturer,
                'purchasedate' => $purchasedate,
                'outlet_id'    => $outlet_name,
                'is_active'    => $is_active,
                'station_image'=> $data_doc,
            );
            $this->stations_model->addstation($data);
            $this->session->set_flashdata('msg', '<div class="alert alert-success text-left">' . $this->lang->line('update_message') . '</div>');
            redirect('admin/stations');
        }
    }

    public function handle_upload_upimage()
    {
        $image_validate = $this->config->item('image_validate');
        $result         = $this->filetype_model->get();
        if (isset($_FILES["upfile"]) && !empty($_FILES['upfile']['name'])) {
           
            $file_type = $_FILES["upfile"]['type'];
            $file_size = $_FILES["upfile"]["size"];
            $file_name = $_FILES["upfile"]["name"];
            $allowed_extension = array_map('trim', array_map('strtolower', explode(',', $result->image_extension)));
            $allowed_mime_type = array_map('trim', array_map('strtolower', explode(',', $result->image_mime)));
            $ext               = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if ($files = @getimagesize($_FILES['upfile']['tmp_name'])) {

                if (!in_array($files['mime'], $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_upimage', $this->lang->line('file_type_not_allowed'));
                    return false;
                }
                if (!in_array($ext, $allowed_extension) || !in_array($file_type, $allowed_mime_type)) {
                    $this->form_validation->set_message('handle_upload_upimage', $this->lang->line('file_type_not_allowed'));
                    return false;
                }

                if ($file_size > $result->image_size) {
                    $this->form_validation->set_message('handle_upload_upimage', $this->lang->line('file_size_shoud_be_less_than') . number_format($image_validate['upload_size'] / 1048576, 2) . " MB");
                    return false;
                }
            } else {
                $this->form_validation->set_message('handle_upload_upimage', $this->lang->line('file_type_not_allowed'));
                return false;
            }

            return true;
        }
        return true;
    } 



    public function getStationStatus($equipment_id=null){
        echo SERVER_URL;
    }

    public function getStationList(){
        echo $this->stations_model->getstationlist();
    }

    public function checkdevices(){
        $this->db->select('station_id')->from('stations');
        $query = $this->db->get()->result_array();
        foreach($query as $value){
            $device_id = $value['station_id'];
            $url = "http://18.217.18.187:6001/middle/v1-1/heart?equipment_sn=".$device_id;
            $data = json_decode ($this->getapi($url),true);
            $last_login = '';
            $status['is_online'] = "no";
            //print_r($data);
            if ($data['msg'] == "OK"){
                
                $last_login = $data['body']['heart_stamp'];
                $current_time = time();
                if (((time() - $last_login ) <= 60)){
                    $status['is_online'] = "yes";
                    $status['is_active'] = "yes";
                    $timezone = "Asia/Muscat";
                    $dt = new DateTime();
                    $dt->setTimestamp($last_login);
                    $dt->setTimezone(new DateTimeZone($timezone));
                    $datetime = $dt->format('d-M-Y H:i:s');
                    $status['lastseen']  = $datetime;
                }else{
                    $timezone = "Asia/Muscat";
                    $dt = new DateTime();
                    $dt->setTimestamp($last_login);
                    $dt->setTimezone(new DateTimeZone($timezone));
                    $datetime = $dt->format('d-M-Y H:i:s');
                    $status['is_online'] = "no";
                    $status['is_active'] = "no";
                    $status['lastseen']  = $datetime;
                }
            }else{
                
                $status['is_active'] = "no";
                $status['lastseen']  = null;
            }
            $status['station_status'] = $data['msg'];
            $status['station_id'] = $device_id;
            $response = $this->stations_model->updatestationstatus($status);
            $this->updateavailablebatteries($device_id);
            //echo json_encode($status).'<br>';

        }
    }

    public function updateavailablebatteries($deviceid){
        $data = file_get_contents("http://18.217.18.187:6001/middle/v1-1/battery?equipment_sn=".$deviceid);
        $data = json_decode ($data,true);
        $batteries = 0;
        if ($data['msg'] == "OK"){
            $batteries = hexdec($data['body']['battery'][3]);        
        }
        $this->stations_model->updateavailablebatteries($deviceid, $batteries);
    }

    public function ejectbattery($deviceid,$orderid){
        $data = file_get_contents("http://18.217.18.187:6001/middle/v1-1/rent?equipment_sn=".$deviceid."&order_id=".$orderid);
        echo "Response: ".$data;
        $data = json_decode ($data,true);
        if ($data['msg'] == "OK"){
            $this->updateavailablebatteries($deviceid);
            $data['status'] = 'Please Collect the Battery.';
        }else{
            $data['status'] = 'Ejection Failed. Contact Support';
        }       
        echo json_encode($data);
    }

    public function getOrderID($deviceid){
            $data = file_get_contents("http://18.217.18.187:6001/middle/v1-1/battery?equipment_sn=".$deviceid);
            //echo "Response: ".$data;
            $data = json_decode ($data,true);
            if ($data['msg'] == "OK"){
                $response['Device_ID'] = $data['body']['sn'];
                $response['Batteries'] = hexdec($data['body']['battery'][3]);
                $len = 4;
                for($i=0;$i<$response['Batteries'];$i++){
                    
                    $response['Battery_'.$i+1]['port_id'] = hexdec($data['body']['battery'][$len]);
                    $response['Battery_'.$i+1]['availability'] = hexdec($data['body']['battery'][$len+1]);
                    $response['Battery_'.$i+1]['power'] = hexdec($data['body']['battery'][$len+2]);
                    $response['Battery_'.$i+1]['battery_id'] ="";
                    for($j=3;$j<10;$j++){
                        $response['Battery_'.$i+1]['battery_id'] .=  $data['body']['battery'][$len+$j];
                    }
                    $response['Battery_'.$i+1]['actions'] = "";
                    $len = $len+11;
                }
            }else{
    
            }       
            echo json_encode($data);

    }

    public function checkbatteries($device_id){
        $data = file_get_contents("http://18.217.18.187:6001/middle/v1-1/battery?equipment_sn=".$device_id);
        $data = json_decode ($data,true);
        $html="";
        if ($data['msg'] == "OK"){
            //$response['Device_ID'] = $data['body']['sn'];
            $batteries = hexdec($data['body']['battery'][3]);
            $len = 4;
            $html .= "<table class='table table-striped custom-table datatable'><thead><th>Order ID</th><th>Availability</th><th>Capacity</th><th>Battery ID</th><th>actions</th></thead><tbody>";
            for($i=0;$i<$batteries;$i++){
                $html .= "<tr>";
                $order_id = hexdec($data['body']['battery'][$len]);
            $html .= "<td>".$order_id."</td>";
            if (hexdec($data['body']['battery'][$len+1])==1){
                $availability = 'Yes';
            }else{
                $availability = 'No';
            }
            $html .= "<td>".$availability."</td>";
            $html .= "<td>".hexdec($data['body']['battery'][$len+2])."%</td>";
                $battery_id ="";
                for($j=3;$j<11;$j++){
                    $battery_id .=  $data['body']['battery'][$len+$j];
                }
                $html .= "<td>".$battery_id."</td>";
                $html .= "<td><button onclick = eject(".$order_id.")>Eject</button></td>";

                $len = $len+11;
            }
        }else{
           $html = "<div id = 'msg' class='error_message'>".print_r($data['msg'])."</div>";

        }       
        echo $html;
    }

    public function getstations(){
        $filter = $this->input->post('stationstatus');
        $liststations       = $this->stations_model->liststations($filter);
        $data['list'] = $liststations;
        $html="";
        if (isset($liststations)){
            $html .= "<div class='table-responsive'><table class='table table-striped custom-table datatable'>";
            $html .= "<thead>
                        <th>S.No</th>
                        <th>Station Name</th>
                        <th>Outlet Name</th>
                        <th>Station ID</th>
                        <th>No of Batteries</th>
                        <th>Manufacturer</th>
                        <th>Purchase Date</th>
                        <th>is Online</th>
                        <th>LastSeen</th>
                        <th>Status</th>
                        <th>Action</th>
                      </thead>";
            $html .= "<tbody>";
            $i=1;
            foreach($liststations as $stations){
                $html .= "<tr>";
                $html .= "<td>".$i."</td>";
                $html .= "<td>
                            <h2 class='table-avatar'>
                            <a href='' class='avatar'>";
                                if($stations['station_image']!=null)
                                {
                                    $html.= "<img alt=''  class='inline-block' src='".base_url()."uploads/stations/images/" .$stations['id'] ."/".$stations['station_image']. "'/>";
                                }
                            $html .="</a>
                            <a href='".base_url()."admin/stations/view/" .$stations['station_id']."'  class='text-primary'>".$stations['station_name']."</a>
                            </h2></td>";
                $html .= "<td>".$stations['outlet_name']."</td>";
                $html .= "<td>".substr($stations['qr_code'],35,13)."</td>";
                $html .= "<td>".$stations['avl_batteries'].'/'.$stations['batteries']."</td>";
                $html .= "<td>".$stations['manufacturer']."</td>";
                $html .= "<td>".$stations['purchasedate']."</td>";              
                $html .= "<td>";
                                if ($stations['is_online'] == 'yes')
                                {
                                    $html.="<a class='btn btn-white btn-sm btn-rounded'> <i class='fa fa-dot-circle-o text-success'></i> Online</a>";
                                }
                                else
                                {
                                    $html.="<a class='btn btn-white btn-sm btn-rounded'><i class='fa fa-dot-circle-o text-danger'></i> Offline</a>";
                                }
                $html.="</td>";
                $html .= "<td class=''>".$stations['lastseen']."</td>";
                $html .= "<td>
                            <div class='dropdown action-label' id='stationactive". $stations['id'] . "'>";
                                if ($stations['is_active'] == 'yes')
                                {
                                    $html.="<a href='' class='btn btn-white btn-sm btn-rounded dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-dot-circle-o text-success'></i> Active </a>";
                                }
                                else
                                {
                                    $html.="<a href='' class='btn btn-white btn-sm btn-rounded dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'><i class='fa fa-dot-circle-o text-danger'></i> Inactive </a>";
                                }
                                $html.="<div class='dropdown-menu'>
                                    <a class='dropdown-item'  onclick=makestationactive(". $stations['id'] .")><i class='fa fa-dot-circle-o text-success'></i> Active</a>
                                    <a class='dropdown-item' onclick=makestationinactive(". $stations['id'] .")><i class='fa fa-dot-circle-o text-danger'></i> Inactive</a>
                                </div>
                            </div>
                          </td>";

                $html .= "<td class='text-end'>
                             <div class='dropdown dropdown-action'>
                                <a href='#' class='action-icon dropdown-toggle' data-bs-toggle='dropdown' aria-expanded='false'><i class='material-icons'>more_vert</i></a>
                                <div class='dropdown-menu dropdown-menu-right'>
                                    <a class='dropdown-item' href='" . base_url() ."admin/stations/edit/" .$this->enc_lib->encrypt($stations['id'])."'><i class='fa fa-pencil m-r-5'></i> Edit</a>
                                    <a class='dropdown-item' href='" . base_url() ."admin/stations/delete/" .$this->enc_lib->encrypt($stations['id'])."'><i class='fa fa-trash-o m-r-5'></i> Delete</a>
                                </div>
                            </div>
                          </td>";
                $html .= "</tr>";
                $i++;
            }

            $html .= "</tbody></table></div>";

        }else{
            $html = "<div id = 'msg' class='error_message'>No Records Found</div>";
        }     
        echo $html;

    }


    
    public function makestationactive()
    {
        $id=$this->input->post('id');
        $data['success']=$this->stations_model->makestationactive($id);
        echo json_encode($data);
    }

    public function makestationinactive()
    {
        $id=$this->input->post('id');
        $data['success']=$this->stations_model->makestationinactive($id);
        echo json_encode($data);
    }

    public function checkuploadimage()
    {
        $id=$this->input->post('id');
        $img=$_FILES["file"];
        $oldimgfile=$this->input->post('oldimg');
        // print_r($img);
        // echo $oldimg;
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {

            if(!empty($oldimgfile))
            {
                $oldfile_path='./uploads/stations/images/'. $id .'/' . $oldimgfile;
                if(is_file($oldfile_path))
                {
                    unlink($oldfile_path);
                }
            }

            $uploaddir = './uploads/stations/images/'. $id .'/';
            if (!is_dir($uploaddir) && !mkdir($uploaddir)) {
                die("Error creating folder". $uploaddir);
            }
            $fileInfo    = pathinfo($_FILES["file"]["name"]);
            $img_name    = $fileInfo['filename'] . '.' . $fileInfo['extension'];
            move_uploaded_file($_FILES["file"]["tmp_name"], $uploaddir.$img_name);
            $data_doc = $img_name;
        }

        $data['success']=$this->stations_model->checkuploadimage($id,$data_doc);
        echo json_encode($data);
    }

    public function testtime(){
        echo time();
    }


    public function getapi($url){
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }

}