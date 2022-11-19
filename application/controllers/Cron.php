<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cron extends CI_Controller
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

    public function checkdevices(){
        $this->db->select('station_id')->from('stations');
        $query = $this->db->get()->result_array();
        print_r($query);
        foreach($query as $value){
            $device_id = $value['station_id'];
            $url = "https://voltafuel.site:6001/middle/v1-1/heart?equipment_sn=".$device_id;
            $data = json_decode ($this->getapi($url),true);
            //print_r($data);
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