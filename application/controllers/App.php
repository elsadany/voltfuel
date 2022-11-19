<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class App extends CI_Controller
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
        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $setting_result = $this->setting_model->getSetting();

            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array(
                    'url'                      => $setting_result->mobile_api_url,
                    'site_url'                 => site_url(),
                    'app_logo'                 => $setting_result->app_logo,
                    'app_primary_color_code'   => $setting_result->app_primary_color_code,
                    'app_secondary_color_code' => $setting_result->app_secondary_color_code,
                    'lang_code'                => $setting_result->language_code,
					'app_ver'                  => $this->customlib->getAppVersion(),	
                )));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(405)
                ->set_output(json_encode(array(
                    'error' => "Method Not Allowed",
                )));
        }
    }

    public function getnearbyoutlets($apikey=null,$data=null){
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $api_key = $this->input->get('apikey');
            $input = $this->input->get('data');
            if ($api_key == "apikey"){   
                $data['input'] = $input;
                $data1 = $this->app_model->getoutlets();
                $data['data'] = $data1;
                //return json_encode($data);
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(500)
                    ->set_output(json_encode($data));
            }else{
                echo "Invalid APIKEY";
            }
        }else{
            echo "Invalid Authentication";
        }
    }

    public function getnearbystations($apikey=null,$data=null){
        //$response = array();
        if ($this->input->server('REQUEST_METHOD') == 'GET') {
            $api_key = $this->input->get('apikey');
            $input = $this->input->get('data');
            if ($api_key == "apikey"){   
                $data['input'] = $input;
                $data1 = $this->app_model->getstations();
                //$response = $data1;
                $i = 1;
                foreach ($data1 as $station){
                    $station['distance'] = 2500;
                    $response[] = $station;

                }
                $data['response'] = $response;

                //return json_encode($data);
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(500)
                    ->set_output(json_encode($data));
            }else{
                echo "Invalid APIKEY";
            }
        }else{
            echo "Invalid Authentication";
        }
    }

    public function getoutlets($apikey=null,$data=null){
        if ($this->input->server('REQUEST_METHOD') == 'GET') {

            $api_key = $this->input->get('apikey');
            if ($api_key == "apikey"){         
                $data1 = $this->app_model->getoutlets();
                $data['data'] = $data1;
                $test="<pre>".var_dump($data1)."</pre>";
                print_r($test);
                //return json_encode($data);
            }else{
                echo "<h1>Invalid APIKEY</h1>";
            }
        }else{
            echo "Invalid Authentication";
        }
    }

    // public function popbattery($apikey=null,$outletid=null,$qrcode=null,$userid=null,$deviceid=null,$devicelat=null,$devicelong=null){
    //     if ($this->input->server('REQUEST_METHOD') == 'GET') {
    //         //echo time();
    //         $api_key = $this->input->get('apikey');
    //         $apitype = 'GET';
    //         $qrcode = $this->input->get('qrcode');
    //         $mobileno = $this->input->get('mobileno');
    //         $deviceid = $this->input->get('deviceid');
    //         $devicelat = $this->input->get('devicelat');
    //         $devicelong = $this->input->get('devicelong');
    //         $outletid = $this->input->get('outletid');
    //     }else{
    //         echo 'Invalid Attempt';
    //     }
    //     $data = array(
    //         'api_type' => $apitype,
    //         'api_key'   => $api_key,
    //         'qrcode'    => $qrcode,
    //         'mobileno'    => $mobileno,
    //         'deviceid'  => $deviceid,
    //         'devicelat' => $devicelat,
    //         'devicelong'=> $devicelong,
    //         'outletid'  => $outletid,
    //     );
    //    // echo "Releasing Battery for QR Code: ".$qrcode." For User ".$userid. " From the Location: ".$devicelat." , ".$devicelong." at the outlet".$outletid."<br>";
    //     if ($this->checkcard($userid) && $this->checkapikey($api_key) && $this->validuser($userid,$deviceid) && $this->validposition($outletid, $qrcode,$devicelat,$devicelong)){  
    //         $this->releasebattery($data);
    //     }else{
    //         echo "<h1>Invalid APIKEY</h1>";
    //     }
    // }

    public function popbattery_post($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey') == null ? $api_key : $this->input->post('apikey');
            $response['key'] = $api_key;
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){

                $mobileno = $this->input->post('mobileno');
                if($this->is_subscriber_exists($mobileno)){
                    $qrcode = $this->input->post('qrcode');
                    $deviceid = $this->input->post('deviceid');
                    $devicelat = $this->input->post('devicelat');
                    $devicelong = $this->input->post('devicelong');
                    $outletid = $this->input->post('outletid');
                    $plan_id = $this->input->post('planid');
                    if (!isset($planid)){
                        $plan_id = 1;
                    }
                    
                    $subscriberdata = $this->app_model->getsubscriber($mobileno);
                    $subscriberid = $subscriberdata->id;
                    $plan_id = $subscriberdata->active_plan;
                    $carddata = $this->app_model->getActiveCard($subscriberid);
                    //$plandata = $this->app_model->getActivePlan($subscriberid);
                    if(isset($carddata)){
                        if ($this->validqr($qrcode) && $this->validposition($outletid, $qrcode,$devicelat,$devicelong)){  
                                $data = array(
                                    'api_type' => $apitype,
                                    'api_key'   => $api_key,
                                    'qrcode'    => $qrcode,
                                    'userid'    => $subscriberid,
                                    'card_id'   => $carddata['id'],
                                    'cardlastfour' => $carddata['cardlastfour'],
                                    'deviceid'  => $deviceid,
                                    'devicelat' => $devicelat,
                                    'devicelong'=> $devicelong,
                                    'outletid'  => $outletid,
                                    'planid' => $plan_id,
                                );
                                $response['apidata_from_mobile'] = json_encode($data);
                                $this->releasebattery($data);
                        }

                    }else{

                        $response['msg'] = 'No Valid Payment Method Found. Please Check your Payment Modes.';
                    }

                }else{
                    $response['msg'] = 'No Subscriber Exists';
                }
        }else{
            echo 'Invalid Api Key';
        }

    }else{
        echo 'Invalid Attempt';
    }
    $response['code'] = 1;
    $response['booking_id'] = '';
    $response['timestamp'] = time();
    $this->app_model->insertapplogs($response);   
    echo json_encode($response); 

}


    public function checkapikey($apikey){
        if($apikey == "apikey"){ 
            return true;
        }else{
            return false;
        }

    }


    public function validqr($qrcode){
        return true;
    }

    public function validuser($userid,$deviceid){
        if($userid == "9789042380"){ 
            return true;
        }else{
            return true;
        }

    }

    public function validposition($qrcode,$devicelat,$devicelong){
        return true;
    }

    public function calculatedistance($devicelat,$devicelong){
        return true;
    }

    public function releasebattery($apidata){
        $device_id = $this->stations_model->getdeviceid($apidata['qrcode']);
        $order_id =  uniqid($apidata['userid']);
        $data = file_get_contents(SERVER_URL."rent?equipment_sn=".$device_id."&order_id=".$order_id);
        $data = json_decode ($data,true);


         $response = array();
         if ($data['msg'] == "OK"){

            $orderdata = array(
                'order_id' => $order_id,
                'battery_id'   => $data['body']['battery'],
                'pipe_num' => $data['body']['pipe_num'],
                'issued_outlet'    => $apidata['outletid'],
                'subscriber_id'    => $apidata['userid'],
                'plan_id'  => $apidata['planid'],
                'card_id'  => $apidata['card_id'],
                'device_id'  => $device_id,
                'order_status'=> 'Pending',
                'is_penalty'  => 0,
            );
            $response['msg'] = "Please Collect Battery.";
            $response['status'] = 'SUCCESS';
            $response['code'] = 0;
            $response['booking_id'] = $order_id;
            $response['timestamp'] = time();
            $this->app_model->insertapplogs($orderdata); 
            $this->createorder($orderdata);
            $this->updateavailablebatteries($device_id);

         }else{
            $response['msg'] = 'Battery Renting Failed. Please contact support';
            $response['status'] = 'ERROR';
            $response['code'] = 1;
            $response['booking_id'] = '';
            $response['timestamp'] = time();
     }   
     $response['apidata_from_mobile'] = json_encode($apidata);
     $this->app_model->insertapplogs($response);    
     echo json_encode($response);
       // echo json_encode($data);
        //echo $order_id;
    }

    public function returnbattery(){

        $returndata = json_decode(file_get_contents('php://input'),true);
        if (isset($returndata)){
            $battery = $returndata['battery'];
            $deviceid = $returndata['equipment_sn'];
            $returnpipe = $returndata['pipe_num'];
            $batterystate = $returndata['ee'];
            $outletid = $this->outlets_model->getoutletid($deviceid);
            $orderdata = $this->orders_model->getOrderDetailsFromBattery($battery);
            $returndata = array(
                'returned_outlet' => $outletid,
                'returned_pipe_num' => $returnpipe,
                'returned_battery_state' => $batterystate,
                'order_status' => 'Completed',
                'returned_at' => date("Y-m-d H:i:s"),
            );

            $this->orders_model->returnorder($returndata,$orderdata['order_id']);
            $data['orderid'] = $orderdata['order_id'];
            $data['logtype']='Return Battery';
            $data['batteryid']=$battery;
            $data['others']=$returndata;
            $this->app_model->insertapplogs($data);
            $this->updateavailablebatteries($deviceid);
            echo json_encode($data);

        }
    }

    public function updateavailablebatteries($deviceid){
        $data = file_get_contents("http://voltafuel.site:6001/middle/v1-1/battery?equipment_sn=".$deviceid);
        $data = json_decode ($data,true);
        //print_r($data);
        $batteries = 0;
        if ($data['msg'] == "OK"){
            $batteries = hexdec($data['body']['battery'][3]);        
        }
        $this->stations_model->updateavailablebatteries($deviceid, $batteries);
    }

    public function getOrderID($deviceid){
        $orderid=0;
        $power = [];
        $data = file_get_contents("http://voltafuel.site:6001/middle/v1-1/battery?equipment_sn=".$deviceid);
        //echo "Batteries: ".$data;
        $data = json_decode ($data,true);
        if ($data['msg'] == "OK"){
            $response['Device_ID'] = $data['body']['sn'];
            $response['Batteries'] = hexdec($data['body']['battery'][3]);
            $len = 4;
            for($i=0;$i<$response['Batteries'];$i++){                
                $portid = hexdec($data['body']['battery'][$len]);
                $availability = hexdec($data['body']['battery'][$len+1]);
                if ($availability) {
                    $power[$portid] = hexdec($data['body']['battery'][$len+2]);
                    $batteryid[$portid] ="";
                    for($j=3;$j<10;$j++){
                        $batteryid[$portid] .=  $data['body']['battery'][$len+$j];
                    }
                }
                $len = $len+11;
            }
        }  
        $orderid = 1;
        //print_r($orderid);
        return $orderid;

    }


    public function addInstallation(){
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            
            $api_key = $this->input->post('apikey');
            $apitype = 'POST';
            $deviceid = $this->input->post('deviceid');
            $osversion = $this->input->post('osversion');
            $osplatform = $this->input->post('osplatform');
            $mobilemake= $this->input->post('mobilemake');
            $mobilemodel = $this->input->post('mobilemodel');
            $devicelat = $this->input->post('devicelat');
            $devicelong = $this->input->post('devicelong');
            $ip = $this->input->post('ipaddress');
            $mobileimei = $this->input->post('mobileimei');

            $data = array(
                'device_id'    => $deviceid,
                'os_version'    => $osversion,
                'os_platform'  => $osplatform,
                'mobile_make' => $mobilemake,
                'mobile_model'=> $mobilemodel,
                'device_lat'  => $devicelat,
                'device_long'  => $devicelong,
                'ipaddress'  => $ip,
                'mobile_imei'  => $mobileimei,
            );

            $this->app_model->apiattemptlog($data);
            if ($this->checkapikey($api_key)){  
                $this->app_model->addinstallation($data);
    
            }else{
                echo "Invalid APIKEY";
            }

    
           
        }else{
            echo 'Invalid Attempt';
        }
    }

    public function getsubscriber($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey');
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $deviceid = $this->input->post('deviceid');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                if($this->is_subscriber_exists($mobileno,$email)){
                    $status =  $this->app_model->getsubscriber($mobileno);
                    if($status == true){                   
                        $response['msg'] = $status;
                        $response['status'] = 'SUCCESS';
                        $response['code'] = 0;
                        $response['success'] = true;
                        // $response['payload'] = $status;
                    }else{
                        $response['msg'] = "Subscriber Not Exists";
                    }
               
                }else{
                    $response['msg'] = "Subscriber Not Exists";
                }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
        

    }

    public function addSubscriber(){
        $data = array();
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey');
            $apitype = 'POST';
            $deviceid = $this->input->post('deviceid');
            $firstname = $this->input->post('firstname');
            $middlename = $this->input->post('middlename');
            $lastname = $this->input->post('lastname');
            $email = $this->input->post('email');
            $mobileno = $this->input->post('mobileno');
            $imageurl = $this->input->post('imageurl');
            $nationalidno = $this->input->post('nationalidno');
            $nationalidimage = $this->input->post('nationalidimage');
            $referrerid = $this->input->post('referrer_id');
            $referralsource = $this->input->post('referral_source');
            $ip = $this->input->post('ipaddress');


            $data = array(
                'firstname'    => $firstname,
                'email' => $email,
                'mobileno' => $mobileno,
                'referrerid' => $referrerid,
                'referral_source' => $referralsource,

            );
            $response = array();

            if ($this->checkapikey($api_key)){
                if(!$this->is_subscriber_exists($mobileno,$email)){  
                    $userid =  $this->app_model->addsubscriber($data, $deviceid);
                        if($userid != ''){                   
                            $response['msg'] = "Subscriber Created Successfully.";
                            $response['status'] = 'SUCCESS';
                            $response['code'] = 0;
                            $response['user_id'] = $userid;
                            $response['timestamp'] = time();
                            $response['success'] = true;
                        }
                    }else{
                        $response['msg'] = "eMail/Mobile Already Exists.";
                        $response['status'] = 'ERROR';
                        $response['code'] = 1;
                        $response['user_id'] = '';
                        $response['timestamp'] = time();
                        $response['success'] = false;  
                    }

            }else{
                $response['msg'] = "Invalid API Key.";
                $response['status'] = 'ERROR';
                $response['code'] = 1;
                $response['user_id'] = '';
                $response['timestamp'] = time();
                $response['success'] = false;   
            }
        }else{
            $response['msg'] = "Invalid API Method";
        }

        $response['apidata_from_mobile'] = json_encode($data);
        $this->app_model->insertapplogs($response);    
        echo json_encode($response);
    }

    public function updateSubscriber(){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey');
            $apitype = 'POST';
            $deviceid = $this->input->post('deviceid');
            $firstname = $this->input->post('firstname');
            $middlename = $this->input->post('middlename');
            $lastname = $this->input->post('lastname');
            $email = $this->input->post('email');
            $dob = $this->input->post('dob');
            $gender = $this->input->post('gender');
            $mobileno = $this->input->post('mobileno');
            $imageurl = $this->input->post('imageurl');
            //$imageurl = $this->input->post('imagefile');
            $nationalidno = $this->input->post('nationalidno');
            $nationalidimage = $this->input->post('nationalidimage');
            $city = $this->input->post('city');
            $country = $this->input->post('country');
            $state = $this->input->post('state');
            $pincode = $this->input->post('pincode');
            $address = $this->input->post('address');

            $data = array(
                'firstname'    => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'email' => $email,
                'mobileno' => $mobileno,
                'gender' => $gender,
                'dob' => $dob,
                'image' => $imageurl,
                'imagefile' => $imageurl,
                'national_id' => $nationalidno,
                'nationalid_imageurl' => $nationalidimage,
                'city' => $city,
                'country' => $country,
                'state' => $state,
                'pincode' => $pincode,
                'address' => $address,
            );

            if ($this->checkapikey($api_key)){
                if($this->is_subscriber_exists($mobileno,$email)){  
                    $status =  $this->app_model->updatesubscriber($data, $mobileno);
                        if($status == true){                   
                            $response['msg'] = "Subscriber Updated Successfully.";
                            $response['status'] = 'SUCCESS';
                            $response['code'] = 0;
                            $response['success'] = true;
                        }else{
                            $response['msg'] = 'Subscriber Updation Failed';
                        }
                    }else{
                        $response['msg'] = "Subscriber Not Exists";
                    }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';

        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
    }

    public function is_subscriber_exists($mobileno=null,$email=null){
        return $this->app_model->issubscriberexists($mobileno,$email);
    }

    public function issubscriberexists(){
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey');
            $apitype = 'POST';
            $deviceid = $this->input->post('deviceid');
            $mobileno = $this->input->post('mobileno');
            $email = $this->input->post('email');
            $data = array(
                'deviceid'    => $deviceid,
                'mobileno' => $mobileno,
                'email' => $email,
            );
            $response = array();
            $response['checkmessage'] = 'hello';
            $response['issubscriberexists'] = false;
            $response['isdeviceexists'] = false;
            if($this->checkapikey($api_key)){
                if($this->is_subscriber_exists($mobileno,$email)){  
                    $response['issubscriberexists'] = true;
                }
                if($this->is_device_exists($deviceid)){  
                    $response['isdeviceexists'] = true;
                }
                
                
            }else{
                $response['msg'] = "Invalid API Key ";
            }
            $response['timestamp'] = time();
            $response['apidata_from_mobile'] = json_encode($data);
            $this->app_model->insertapplogs($response);    
            echo json_encode($response);
        }

    }

    public function is_device_exists($deviceid){
        echo $this->app_model->isdeviceexists($deviceid);
    }

    public function getpricingcategories($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey') == null ? $api_key : $this->input->post('apikey');
            $response['key'] = $api_key;
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $deviceid = $this->input->post('deviceid');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                $data = array(
                    'apikey' => $api_key,
                    'mobileno' => $mobileno,
                );
                if($this->is_subscriber_exists($mobileno)){
                    $status =  $this->app_model->getpricingcategories();
                    if($status == true){                   
                        $response['msg'] = $status;
                        $response['status'] = 'SUCCESS';
                        $response['code'] = 0;
                        $response['success'] = true;
                        // $response['payload'] = $status;
                    }else{
                        $response['msg'] = $status;
                    }              
                }else{
                    $response['msg'] = "Subscriber Not Exists";
                }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
    }

    public function getpricingplans($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey') == null ? $api_key : $this->input->post('apikey');
            $response['key'] = $api_key;
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $deviceid = $this->input->post('deviceid');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                $data = array(
                    'apikey' => $api_key,
                    'mobileno' => $mobileno,
                );
                if($this->is_subscriber_exists($mobileno)){
                    $status =  $this->app_model->getpricingplans();
                    if($status == true){                   
                        $response['msg'] = $status;
                        $response['status'] = 'SUCCESS';
                        $response['code'] = 0;
                        $response['success'] = true;
                        $response['activeplans'] = json_decode($this->app_model->getactiveplans($mobileno));
                        // $response['payload'] = $status;
                    }else{
                        $response['msg'] = 'No Records Found';
                    }              
                }else{
                    $response['msg'] = "Subscriber Not Exists";
                }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
    }

    public function getplanamount($api_key=null,$plan_id=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'GET'){
            $api_key = $this->input->get('apikey') == null ? $api_key : $this->input->get('apikey');
            $plan_id= $this->input->get('planid') == null ? $api_key : $this->input->get('planid');
            $response['key'] = $api_key;
            $apitype = 'GET';
            if ($this->checkapikey($api_key)){
                $data = array(
                    'apikey' => $api_key,
                );
                $status =  $this->app_model->getplanamount($plan_id);
                if($status == true){                   
                    $response['msg'] = $status;
                    $response['status'] = 'SUCCESS';
                    $response['code'] = 0;
                    $response['success'] = true;

                    // $response['payload'] = $status;
                }else{
                    $response['msg'] = 'No Records Found';
                }              
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
    }

    public function subscribeToPlan($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey') == null ? $api_key : $this->input->post('apikey');
            $response['key'] = $api_key;
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $deviceid = $this->input->post('deviceid');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                $plan_id = $this->input->post('planid');
                $data = array(
                    'apikey' => $api_key,
                    'mobileno' => $mobileno,
                );
                if($this->is_subscriber_exists($mobileno)){
                    $status =  $this->app_model->subscribetoplan($mobileno, $plan_id);
                    if($status == true){                   
                        $response['msg'] = 'Plan Subscribed Successfully';
                        $response['status'] = 'SUCCESS';
                        $response['code'] = 0;
                        $response['success'] = true;
                        // $response['activeplans'] = $this->app_model->subscribetoplan($mobileno);
                        // $response['payload'] = $status;
                    }else{
                        $response['msg'] = 'No Records Found';
                    }              
                }else{
                    $response['msg'] = "Subscriber Not Exists";
                }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
    }

    public function unsubscribeToPlan($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey') == null ? $api_key : $this->input->post('apikey');
            $response['key'] = $api_key;
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $deviceid = $this->input->post('deviceid');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                $plan_id = $this->input->post('planid');
                $data = array(
                    'apikey' => $api_key,
                    'mobileno' => $mobileno,
                );
                if($this->is_subscriber_exists($mobileno)){
                    $status =  $this->app_model->unsubscribeplan($mobileno, $plan_id);
                    if($status == true){                   
                        $response['msg'] = 'Plan Unsubsribed Successfully';
                        $response['status'] = 'SUCCESS';
                        $response['code'] = 0;
                        $response['success'] = true;
                        // $response['activeplans'] = $this->app_model->subscribetoplan($mobileno);
                        // $response['payload'] = $status;
                    }else{
                        $response['msg'] = 'No plans found';
                    }              
                }else{
                    $response['msg'] = "Subscriber Not Exists";
                }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
    }

    public function getreferralsources($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey') == null ? $api_key : $this->input->post('apikey');
            $response['key'] = $api_key;
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $status =  $this->app_model->getreferralsources();
                if($status == true){                   
                    $response['msg'] = $status;
                    $response['status'] = 'SUCCESS';
                    $response['code'] = 0;
                    $response['success'] = true;
                    // $response['payload'] = $status;
                }else{
                    $response['msg'] = 'No Records Found';
                }              
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
    }

    public function testapi($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey');
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $deviceid = $this->input->post('deviceid');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                if($this->is_subscriber_exists($mobileno,$email)){
                    $status =  $this->app_model->getsubscriber($mobileno);
                    if($status == true){                   
                        $response['msg'] = $status;
                        $response['status'] = 'SUCCESS';
                        $response['code'] = 0;
                        $response['success'] = true;
                        // $response['payload'] = $status;
                    }else{
                        $response['msg'] = "Subscriber Not Exists";
                    }              
                }else{
                    $response['msg'] = "Subscriber Not Exists";
                }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
    }

    public function upload_profile_pic(){

    }

    public function handle_upload(){
        $error ='';
        if (isset($_FILES["file"]) && !empty($_FILES['file']['name'])) {
            $allowedExts = array('jpg', 'jpeg', 'png');
            $temp        = explode(".", $_FILES["file"]["name"]);
            $extension   = end($temp);
            if ($_FILES["file"]["error"] > 0) {
                $error .= "Error opening the file<br />";
            }
            if ($_FILES["file"]["type"] != 'image/gif' &&
                $_FILES["file"]["type"] != 'image/jpeg' &&
                $_FILES["file"]["type"] != 'image/png') {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_type_not_allowed'));
                return false;
            }
            if (!in_array($extension, $allowedExts)) {
                $this->form_validation->set_message('handle_upload', $this->lang->line('extension_not_allowed'));
                return false;
            }
            if ($_FILES["file"]["size"] > 1024000) {
                $this->form_validation->set_message('handle_upload', $this->lang->line('file_size_shoud_be_less_than') . " 1MB");
                return false;
            }
            return true;
        } else {
            $this->form_validation->set_message('handle_upload', $this->lang->line('logo_file_is_required'));
            return false;
        }
    }

    public function getdistance($devicelat, $devicelong, $userlat, $userlong){

    }

    public function getorders($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey') == null ? $api_key : $this->input->post('apikey');
            $response['key'] = $api_key;
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $deviceid = $this->input->post('deviceid');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                $data = array(
                    'apikey' => $api_key,
                    'mobileno' => $mobileno,
                );
                if($this->is_subscriber_exists($mobileno)){
                    $subscriberid = $this->app_model->getsubscriberid($mobileno);
                    $status =  $this->app_model->getorders($subscriberid);
                    if($status == true){                   
                        $response['msg'] = $status;
                        $response['status'] = 'SUCCESS';
                        $response['code'] = 0;
                        $response['success'] = true;
                        // $response['payload'] = $status;
                    }else{
                        $response['msg'] = 'No Records Found';
                    }              
                }else{
                    $response['msg'] = "Subscriber Not Exists";
                }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));

    }

    public function savecard($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey') == null ? $api_key : $this->input->post('apikey');
            $response['key'] = $api_key;
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $deviceid = $this->input->post('deviceid');
                $mobileno = $this->input->post('mobileno');
                $cardnum = $this->input->post('cardno');
                $cardexpiryyear = $this->input->post('cardexpiryyear');
                $cardexpirymonth = $this->input->post('cardexpirymonth');
                $cardholdername = $this->input->post('cardholdername');
                $cardcvv = $this->input->post('cardcvv');
                $cardtype = $this->input->post('cardtype');
                $cardkey = $this->input->post('key');
                $subscriberid = $this->app_model->getsubscriberid($mobileno);
                $data = array(
                    'subscriber_id' => $subscriberid,
                    'cardnum' =>  $this->enc_lib->encrypt($cardnum),
                    'cardexpiryyear' =>  $this->enc_lib->encrypt($cardexpiryyear),
                    'cardexpirymonth' =>  $this->enc_lib->encrypt($cardexpirymonth),
                    'cardvalidfromyear' =>  $this->enc_lib->encrypt($cardexpiryyear),
                    'cardvalidfrommonth' =>  $this->enc_lib->encrypt($cardexpiryyear),
                    'cardholdername' =>  $this->enc_lib->encrypt($cardholdername),
                    'cardtype' => $cardtype,
                    'cardkey' => $cardkey,
                    'cardcvv' => $this->enc_lib->encrypt($cardcvv),
                    'cardlastfour' => substr($cardnum,-4)
                );
                if($this->is_subscriber_exists($mobileno)){

                    $status =  $this->app_model->savecard($data);
                    if($status == true){                   
                        $response['msg'] = $status;
                        $response['status'] = 'SUCCESS';
                        $response['code'] = 0;
                        $response['success'] = true;
                        // $response['payload'] = $status;
                    }else{
                        $response['msg'] = 'No Records Found';
                    }              
                }else{
                    $response['msg'] = "Subscriber Not Exists";
                }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
    }

    public function getcards($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey') == null ? $api_key : $this->input->post('apikey');
            $response['key'] = $api_key;
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $deviceid = $this->input->post('deviceid');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                $data = array(
                    'apikey' => $api_key,
                    'mobileno' => $mobileno,
                );
                if($this->is_subscriber_exists($mobileno)){
                    $subscriberid = $this->app_model->getsubscriberid($mobileno);
                    $status =  $this->app_model->getcards($subscriberid);
                    if($status == true){                   
                        $response['msg'] = $status;
                        $response['status'] = 'SUCCESS';
                        $response['code'] = 0;
                        $response['success'] = true;
                        // $response['payload'] = $status;
                    }else{
                        $response['msg'] = 'No Records Found';
                    }              
                }else{
                    $response['msg'] = "Subscriber Not Exists";
                }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));

    }

    public function deletecard($api_key=null){

    }

    public function processpayment($api_key=null){
        $data['orderid'] = '13579';
        $data['amount'] = '1.008';
        echo json_encode($data);
    }

    public function mywallet($api_key=null){
        $data = array();
        $response['status'] = 'ERROR';
        $response['success'] = false;   
        if ($this->input->server('REQUEST_METHOD') == 'POST'){
            $api_key = $this->input->post('apikey') == null ? $api_key : $this->input->post('apikey');
            $response['key'] = $api_key;
            $apitype = 'POST';
            if ($this->checkapikey($api_key)){
                $deviceid = $this->input->post('deviceid');
                $mobileno = $this->input->post('mobileno');
                $email = $this->input->post('email');
                $data = array(
                    'apikey' => $api_key,
                    'mobileno' => $mobileno,
                );
                if($this->is_subscriber_exists($mobileno)){
                    $subscriberid = $this->app_model->getsubscriberid($mobileno);
                    $status =  $this->app_model->getcards($subscriberid);
                    if($status == true){                   
                        $response['msg'] = $status;
                        $response['status'] = 'SUCCESS';
                        $response['code'] = 0;
                        $response['success'] = true;
                        // $response['payload'] = $status;
                    }else{
                        $response['msg'] = 'No Records Found';
                    }              
                }else{
                    $response['msg'] = "Subscriber Not Exists";
                }
            }else{
                $response['msg'] = "Invalid API Key.";               
            }
        }else{
            $response['msg'] = 'Method Not Allowed';
        }
        $response['timestamp'] = time();
        $response['apidata_from_mobile'] = $data;
        $this->app_model->insertapplogs($response);    
        return $this->output
        ->set_content_type('application/json')
        ->set_status_header(405)
        ->set_output(json_encode($response));
    }

    public function test(){
        $planamount = file_get_contents("http://sensemeters.com/vfadmin/app/getplanamount?apikey=apikey&planid=5");
        $planamount = json_decode($planamount,true);
        echo $planamount;
    }

    public function testorder(){
        $data = array(
            'order_id' => uniqid(4),
            'battery_id'   => '1F1215614DB9ED9C',
            'pipe_num' => '0A',
            'issued_outlet'    => 4,
            'subscriber_id'    => 4,
            'plan_id'  => 1,
            'device_id'  => '1FA728614D9F2C69',
            'order_status'=> 'Pending',
            'is_penalty'  => 0,
        );
        $this->createorder($data);
    }

    public function createorder($data){
        return $this->orders_model->createorder($data);
    }

    public function ejectbattery($apidata = null){
        $apidata = array(
            'userid' => 4,
        );
        $device_id = 'FFB7275FD82581BD';
        $order_id =  uniqid($apidata['userid']);
        $data = file_get_contents(SERVER_URL."rent?equipment_sn=".$device_id."&order_id=".$order_id);

        $data = json_decode ($data,true);
        print_r($data);
    }

     public function testreturn(){
        $data = file_get_contents("https://admin.voltafuel.site/vfadmin/app/returnbattery");

        $data = json_decode ($data,true);
        print_r($data);

     }





}